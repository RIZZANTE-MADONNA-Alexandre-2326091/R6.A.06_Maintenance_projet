import React, { useEffect, useState } from 'react';
import { api } from '../services/api';
import './Sports.css';
import { Users, User, Trophy, Activity } from 'lucide-react';

const Sports = () => {
    const [sports, setSports] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    useEffect(() => {
        const fetchSports = async () => {
            try {
                const data = await api.getSports();
                console.log("API Reference received:", data);

                // Robust verification
                let sportsArray = [];
                if (Array.isArray(data)) {
                    sportsArray = data;
                } else if (data && Array.isArray(data['hydra:member'])) {
                    sportsArray = data['hydra:member'];
                } else if (data && Array.isArray(data.member)) {
                    sportsArray = data.member;
                }

                if (sportsArray.length === 0) {
                    console.warn("Sports array is empty. Raw data:", data);
                }

                setSports(sportsArray);
            } catch (err) {
                console.error("Error loading sports:", err);
                setError("Impossible de charger les sports. Veuillez réessayer plus tard.");
            } finally {
                setLoading(false);
            }
        };

        fetchSports();
    }, []);

    const getIcon = (type) => {
        switch (type) {
            case 'equipe':
                return <Users size={40} />;
            case 'individuel':
                return <User size={40} />;
            case 'indiEquipe':
                return <Trophy size={40} />;
            default:
                return <Activity size={40} />;
        }
    };

    const formatType = (type) => {
        switch (type) {
            case 'equipe': return 'Sport Collectif';
            case 'individuel': return 'Sport Individuel';
            case 'indiEquipe': return 'Mixte';
            default: return type;
        }
    };

    if (loading) {
        return (
            <div className="loader-container">
                <span className="loader"></span>
            </div>
        );
    }

    if (error) {
        return <div className="error-message">{error}</div>;
    }

    return (
        <div className="sports-page">
            <header className="sports-header">
                <h1 className="sports-title">Nos Sports</h1>
                <p className="sports-subtitle">
                    Découvrez l'ensemble des disciplines proposées par l'UGSEL 35 pour l'épanouissement de tous les élèves.
                </p>
            </header>

            <div className="sports-grid">
                {sports.length > 0 ? (
                    sports.map((sport) => (
                        <div key={sport.id} className="sport-card">
                            <div className="sport-icon-wrapper">
                                {getIcon(sport.type)}
                            </div>
                            <h2 className="sport-name">{sport.name}</h2>
                            <span className="sport-type">{formatType(sport.type)}</span>
                        </div>
                    ))
                ) : (
                    <div className="empty-state">
                        <p>Aucun sport disponible pour le moment.</p>
                    </div>
                )}
            </div>
        </div>
    );
};

export default Sports;
