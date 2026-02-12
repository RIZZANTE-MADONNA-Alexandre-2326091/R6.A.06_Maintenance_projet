import React, { useEffect, useState } from 'react';
import { useParams, Link } from 'react-router-dom';
import { api } from '../services/api';
import Card from '../components/Card';
import Badge from '../components/Badge';
import { ArrowLeft, Trophy, Users, User, Medal } from 'lucide-react';
import './ChampionnatDetails.css';

const ChampionnatDetails = () => {
    const { id } = useParams();
    const [championnat, setChampionnat] = useState(null);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        const loadData = async () => {
            try {
                // Here we might need a specific endpoint or just fetch the generic detail
                // The current API might return the full tree if serialization groups are correct
                const data = await api.getChampionnatById(id);
                setChampionnat(data);
            } catch (err) {
                console.error("Failed to load details", err);
            } finally {
                setLoading(false);
            }
        };
        loadData();
    }, [id]);

    if (loading) return <div className="loading">Chargement...</div>;
    if (!championnat) return <div className="not-found">Championnat introuvable.</div>;

    const getIcon = (type) => {
        switch (type) {
            case 'equipe': return <Users size={20} />;
            case 'individuel': return <User size={20} />;
            case 'indiEquipe': return <Medal size={20} />;
            default: return <Trophy size={20} />;
        }
    };

    return (
        <div className="details-page">
            <div className="details-container">
                <Link to="/championnats" className="back-link">
                    <ArrowLeft size={20} />
                    Retour aux championnats
                </Link>

                <header className="details-header">
                    <h1>{championnat.name}</h1>
                    <p className="details-subtitle">Détails des compétitions et épreuves</p>
                </header>

                <div className="details-content">
                    {championnat.competitions && championnat.competitions.length > 0 ? (
                        championnat.competitions.map(comp => (
                            <section key={comp.id} className="competition-section">
                                <div className="competition-header">
                                    <h2 className="competition-title">{comp.name}</h2>
                                    <span className="badge-count">{comp.epreuves ? comp.epreuves.length : 0} épreuves</span>
                                </div>

                                <div className="epreuves-grid">
                                    {comp.epreuves && comp.epreuves.length > 0 ? (
                                        comp.epreuves.map(epreuve => (
                                            <Card key={epreuve.id} className="epreuve-card">
                                                <div className="epreuve-top">
                                                    <div className="epreuve-icon">
                                                        {epreuve.sport ? getIcon(epreuve.sport.type) : <Trophy size={20} />}
                                                    </div>
                                                    <Badge variant="primary">{epreuve.sport ? epreuve.sport.name : 'Sport'}</Badge>
                                                </div>
                                                <div className="epreuve-body">
                                                    <h3>{epreuve.name}</h3>
                                                    <p className="epreuve-description">Inscriptions ouvertes</p>
                                                </div>
                                                <button className="btn-register">S'inscrire</button>
                                            </Card>
                                        ))
                                    ) : (
                                        <div className="no-epreuves">
                                            <p>Aucune épreuve planifiée pour le moment.</p>
                                        </div>
                                    )}
                                </div>
                            </section>
                        ))
                    ) : (
                        <div className="no-data">
                            <p>Aucune compétition associée à ce championnat.</p>
                        </div>
                    )}
                </div>
            </div>
        </div>
    );
};

export default ChampionnatDetails;
