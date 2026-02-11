import React, { useEffect, useState } from 'react';
import { useParams, Link } from 'react-router-dom';
import { api } from '../services/api';
import Card from '../components/Card';
import Badge from '../components/Badge';
import { ArrowLeft, Calendar, MapPin, Trophy, Users } from 'lucide-react';
import './ChampionnatDetails.css';

const ChampionnatDetails = () => {
    const { id } = useParams();
    const [championnat, setChampionnat] = useState(null);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        const loadData = async () => {
            try {
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

    return (
        <div className="details-page">
            <Link to="/championnats" className="back-link">
                <ArrowLeft size={20} />
                Retour aux championnats
            </Link>

            <div className="details-header">
                <div className="header-badges">
                    <Badge variant="primary">{championnat.sport.name}</Badge>
                    <Badge variant="secondary">{championnat.statut}</Badge>
                </div>
                <h1>{championnat.libelle}</h1>
                <div className="header-meta">
                    <div className="meta-item">
                        <Calendar className="meta-icon" />
                        <span>{new Date(championnat.dateDeb).toLocaleDateString('fr-FR', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })}</span>
                    </div>
                    <div className="meta-item">
                        <MapPin className="meta-icon" />
                        <span>{championnat.lieu}</span>
                    </div>
                </div>
            </div>

            <div className="details-content">
                <section className="epreuves-section">
                    <h2>Épreuves</h2>
                    <div className="epreuves-grid">
                        {championnat.epreuves.length > 0 ? (
                            championnat.epreuves.map(epreuve => (
                                <Card key={epreuve.id} className="epreuve-card">
                                    <div className="epreuve-icon">
                                        {epreuve.type === 'Equipe' ? <Users /> : <Trophy />}
                                    </div>
                                    <div className="epreuve-info">
                                        <h3>{epreuve.libelle}</h3>
                                        <span className="epreuve-type">{epreuve.type}</span>
                                    </div>
                                    <button className="btn-register">S'inscrire</button>
                                </Card>
                            ))
                        ) : (
                            <p className="no-epreuves">Aucune épreuve disponible pour le moment.</p>
                        )}
                    </div>
                </section>

                <section className="infos-section">
                    <h2>Informations</h2>
                    <Card className="info-card">
                        <p className="description">{championnat.description}</p>
                        <div className="info-rules">
                            <h3>Règlement</h3>
                            <p>Le règlement officiel de l'UGSEL s'applique à cette compétition.</p>
                        </div>
                    </Card>
                </section>
            </div>
        </div>
    );
};

export default ChampionnatDetails;
