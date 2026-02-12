import React, { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';
import { api } from '../services/api';
import Card from '../components/Card';
import { ChevronRight, Trophy } from 'lucide-react';
import './Championnats.css';

const Championnats = () => {
    const [championnats, setChampionnats] = useState([]);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        const loadData = async () => {
            try {
                const data = await api.getChampionnats();
                console.log("Championnats data received:", data);

                // Robust verification
                let items = [];
                if (Array.isArray(data)) {
                    items = data;
                } else if (data && Array.isArray(data['hydra:member'])) {
                    items = data['hydra:member'];
                } else if (data && Array.isArray(data.member)) {
                    items = data.member;
                }

                setChampionnats(items);
            } catch (err) {
                console.error("Failed to load championnats", err);
            } finally {
                setLoading(false);
            }
        };
        loadData();
    }, []);

    if (loading) return <div className="loading">Chargement...</div>;

    return (
        <div className="championnats-page">
            <header className="sports-header">
                <h1 className="sports-title">Championnats</h1>
                <p className="sports-subtitle">
                    Accédez aux compétitions par niveau (Départemental, Régional, National).
                </p>
            </header>

            <div className="championnats-grid">
                {championnats.length > 0 ? (
                    championnats.map(champ => (
                        <Link key={champ.id} to={`/championnats/${champ.id}`} className="championnat-card">
                            <div className="championnat-card-content">
                                <div className="championnat-icon">
                                    <Trophy size={48} />
                                </div>
                                <h2>{champ.name}</h2>
                                <span className="competition-count">
                                    {champ.competitions ? champ.competitions.length : 0} Compétitions
                                </span>
                            </div>
                            <div className="card-footer">
                                <span>Voir les compétitions</span>
                                <ChevronRight />
                            </div>
                        </Link>
                    ))
                ) : (
                    <div className="no-results">Aucun championnat disponible.</div>
                )}
            </div>
        </div>
    );
};

export default Championnats;
