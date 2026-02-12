import React, { useState, useEffect } from 'react';
import { api } from '../services/api';
import { Plus, Trophy, Activity, Target, Layers, Trash2, Edit2, X, Check } from 'lucide-react';
import './Gestion.css';

const Gestion = () => {
    const [activeTab, setActiveTab] = useState('sport');
    const [sports, setSports] = useState([]);
    const [championnats, setChampionnats] = useState([]);
    const [competitions, setCompetitions] = useState([]);
    const [epreuves, setEpreuves] = useState([]);

    // Editing state
    const [editingId, setEditingId] = useState(null);
    const [editValue, setEditValue] = useState('');

    const [status, setStatus] = useState({ type: '', message: '' });

    const loadData = async () => {
        try {
            const [s, c, compData, eprevData] = await Promise.all([
                api.getSports(),
                api.getChampionnats(),
                api.getCompetitions(),
                api.getEpreuves()
            ]);

            setSports(Array.isArray(s) ? s : []);
            setChampionnats(Array.isArray(c) ? c : []);
            setCompetitions(Array.isArray(compData) ? compData : []);
            setEpreuves(Array.isArray(eprevData) ? eprevData : []);
        } catch (err) {
            console.error("LoadData error:", err);
        }
    };

    useEffect(() => {
        loadData();
    }, []);

    const showStatus = (type, message) => {
        setStatus({ type, message });
        setTimeout(() => setStatus({ type: '', message: '' }), 5000);
    };

    const handleDelete = async (type, id) => {
        if (!window.confirm(`Êtes-vous sûr de vouloir supprimer cet élément ?`)) return;
        try {
            switch (type) {
                case 'sport': await api.deleteSport(id); break;
                case 'championnat': await api.deleteChampionnat(id); break;
                case 'competition': await api.deleteCompetition(id); break;
                case 'epreuve': await api.deleteEpreuve(id); break;
                default: break;
            }
            showStatus('success', 'Élément supprimé !');
            loadData();
        } catch (err) { showStatus('error', 'Erreur suppression.'); }
    };

    const handleUpdate = async (type, id) => {
        if (!editValue.trim()) return;
        try {
            const data = { name: editValue };
            switch (type) {
                case 'sport': await api.updateSport(id, data); break;
                case 'championnat': await api.updateChampionnat(id, data); break;
                case 'competition': await api.updateCompetition(id, data); break;
                case 'epreuve': await api.updateEpreuve(id, data); break;
                default: break;
            }
            showStatus('success', 'Élément modifié !');
            setEditingId(null);
            loadData();
        } catch (err) { showStatus('error', 'Erreur modification.'); }
    };

    const startEdit = (item) => {
        setEditingId(item.id);
        setEditValue(item.name);
    };

    const handleCreateSport = async (e) => {
        e.preventDefault();
        const formData = new FormData(e.target);
        try {
            await api.createSport({ name: formData.get('name'), type: formData.get('type') });
            showStatus('success', 'Sport créé !');
            e.target.reset();
            loadData();
        } catch (err) { showStatus('error', 'Erreur création sport.'); }
    };

    const handleCreateChampionnat = async (e) => {
        e.preventDefault();
        const formData = new FormData(e.target);
        try {
            await api.createChampionnat({ name: formData.get('name') });
            showStatus('success', 'Championnat créé !');
            e.target.reset();
            loadData();
        } catch (err) { showStatus('error', 'Erreur création championnat.'); }
    };

    const handleCreateCompetition = async (e) => {
        e.preventDefault();
        const formData = new FormData(e.target);
        try {
            await api.createCompetition({
                name: formData.get('name'),
                championnat: `/api/championnats/${formData.get('championnat')}`
            });
            showStatus('success', 'Compétition créée !');
            e.target.reset();
            loadData();
        } catch (err) { showStatus('error', 'Erreur création compétition.'); }
    };

    const handleCreateEpreuve = async (e) => {
        e.preventDefault();
        const formData = new FormData(e.target);
        try {
            await api.createEpreuve({
                name: formData.get('name'),
                competition: `/api/competitions/${formData.get('competition')}`,
                sport: `/api/sports/${formData.get('sport')}`
            });
            showStatus('success', 'Épreuve créée !');
            e.target.reset();
            loadData();
        } catch (err) { showStatus('error', 'Erreur création épreuve.'); }
    };

    const renderList = (items, type) => (
        <div className="admin-list">
            <div className="list-container">
                {items.length > 0 ? items.map(item => (
                    <div key={item.id} className="list-item">
                        {editingId === item.id ? (
                            <div className="edit-mode">
                                <input
                                    value={editValue}
                                    onChange={(e) => setEditValue(e.target.value)}
                                    autoFocus
                                />
                                <button onClick={() => handleUpdate(type, item.id)} className="btn-save"><Check size={16} /></button>
                                <button onClick={() => setEditingId(null)} className="btn-cancel"><X size={16} /></button>
                            </div>
                        ) : (
                            <>
                                <span className="item-name">{item.name}</span>
                                <div className="item-actions">
                                    <button onClick={() => startEdit(item)} className="btn-edit"><Edit2 size={16} /></button>
                                    <button onClick={() => handleDelete(type, item.id)} className="btn-delete"><Trash2 size={16} /></button>
                                </div>
                            </>
                        )}
                    </div>
                )) : <div className="empty-list">Aucun élément disponible.</div>}
            </div>
        </div>
    );

    return (
        <div className="admin-page">
            <header className="admin-header">
                <h1>Gestion</h1>
                <p>Modifiez, créez ou supprimez n'importe quelle donnée.</p>
            </header>

            {status.message && (
                <div className={`status-banner ${status.type}`}>
                    {status.message}
                </div>
            )}

            <div className="admin-tabs">
                <button className={activeTab === 'sport' ? 'active' : ''} onClick={() => setActiveTab('sport')}>
                    <Activity size={20} /> Sports
                </button>
                <button className={activeTab === 'championnat' ? 'active' : ''} onClick={() => setActiveTab('championnat')}>
                    <Target size={20} /> Championnats
                </button>
                <button className={activeTab === 'competition' ? 'active' : ''} onClick={() => setActiveTab('competition')}>
                    <Layers size={20} /> Compétitions
                </button>
                <button className={activeTab === 'epreuve' ? 'active' : ''} onClick={() => setActiveTab('epreuve')}>
                    <Trophy size={20} /> Épreuves
                </button>
            </div>

            <main className="admin-content">
                <div className="admin-card">
                    {activeTab === 'sport' && (
                        <section className="admin-section">
                            <h2>Ajouter un Sport</h2>
                            <form onSubmit={handleCreateSport} className="admin-form-horizontal">
                                <input name="name" type="text" placeholder="Nom du sport" required />
                                <select name="type" required>
                                    <option value="individuel">Individuel</option>
                                    <option value="equipe">Équipe</option>
                                    <option value="indiEquipe">Mixte</option>
                                </select>
                                <button type="submit" className="btn-submit">Créer</button>
                            </form>
                            {renderList(sports, 'sport')}
                        </section>
                    )}

                    {activeTab === 'championnat' && (
                        <section className="admin-section">
                            <h2>Ajouter un Championnat</h2>
                            <form onSubmit={handleCreateChampionnat} className="admin-form-horizontal">
                                <input name="name" type="text" placeholder="Nom du championnat" required />
                                <button type="submit" className="btn-submit">Créer</button>
                            </form>
                            {renderList(championnats, 'championnat')}
                        </section>
                    )}

                    {activeTab === 'competition' && (
                        <section className="admin-section">
                            <h2>Ajouter une Compétition</h2>
                            <form onSubmit={handleCreateCompetition} className="admin-form-horizontal">
                                <input name="name" type="text" placeholder="Nom de la compétition" required />
                                <select name="championnat" required>
                                    <option value="">Championnat...</option>
                                    {championnats.map(c => <option key={c.id} value={c.id}>{c.name}</option>)}
                                </select>
                                <button type="submit" className="btn-submit">Créer</button>
                            </form>
                            {renderList(competitions, 'competition')}
                        </section>
                    )}

                    {activeTab === 'epreuve' && (
                        <section className="admin-section">
                            <h2>Ajouter une Épreuve</h2>
                            <form onSubmit={handleCreateEpreuve} className="admin-form-horizontal">
                                <input name="name" type="text" placeholder="Nom de l'épreuve" required />
                                <select name="competition" required>
                                    <option value="">Compétition...</option>
                                    {competitions.map(c => <option key={c.id} value={c.id}>{c.name}</option>)}
                                </select>
                                <select name="sport" required>
                                    <option value="">Sport...</option>
                                    {sports.map(s => <option key={s.id} value={s.id}>{s.name}</option>)}
                                </select>
                                <button type="submit" className="btn-submit">Créer</button>
                            </form>
                            {renderList(epreuves, 'epreuve')}
                        </section>
                    )}
                </div>
            </main>
        </div>
    );
};

export default Gestion;
