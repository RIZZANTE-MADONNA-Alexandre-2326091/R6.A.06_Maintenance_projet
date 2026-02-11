import React, { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';
import { api } from '../services/api';
import Card from '../components/Card';
import Badge from '../components/Badge';
import Select from '../components/Select';
import { Calendar, MapPin, Search } from 'lucide-react';
import './Championnats.css';

const Championnats = () => {
    const [championnats, setChampionnats] = useState([]);
    const [sports, setSports] = useState([]);
    const [loading, setLoading] = useState(true);
    const [filterSport, setFilterSport] = useState('all');
    const [search, setSearch] = useState('');

    useEffect(() => {
        const loadData = async () => {
            try {
                const [champsData, sportsData] = await Promise.all([
                    api.getChampionnats(),
                    api.getSports()
                ]);
                setChampionnats(champsData);
                setSports(sportsData);
            } catch (err) {
                console.error("Failed to load data", err);
            } finally {
                setLoading(false);
            }
        };
        loadData();
    }, []);

    const filteredChampionnats = championnats.filter(c => {
        const matchesSport = filterSport === 'all' || c.sportId === parseInt(filterSport);
        const matchesSearch = c.libelle.toLowerCase().includes(search.toLowerCase());
        return matchesSport && matchesSearch;
    });

    const getStatusVariant = (status) => {
        if (status === 'Inscriptions ouvertes') return 'success';
        if (status === 'Inscriptions fermées') return 'danger';
        return 'secondary';
    };

    if (loading) return <div className="loading">Chargement...</div>;

    return (
        <div className="championnats-page">
            <div className="page-header">
                <h1>Vivez les Championnats</h1>
                <p>Découvrez les compétitions UGSEL 35</p>
            </div>

            <div className="filters">
                <div className="search-bar">
                    <Search size={18} className="search-icon" />
                    <input
                        type="text"
                        placeholder="Rechercher un championnat..."
                        value={search}
                        onChange={(e) => setSearch(e.target.value)}
                    />
                </div>

                <Select
                    options={[{ value: 'all', label: 'Tous les sports' }, ...sports.map(s => ({ value: s.id, label: s.name }))]}
                    value={filterSport}
                    onChange={(value) => setFilterSport(value)}
                    className="sport-select-container"
                    placeholder="Filtrer par sport"
                />
            </div>

            <div className="championnats-grid">
                {filteredChampionnats.map(champ => (
                    <Link to={`/championnats/${champ.id}`} key={champ.id}>
                        <Card className="champ-card">
                            <div className="champ-header">
                                <Badge variant="primary">{champ.sport.name}</Badge>
                                <Badge variant={getStatusVariant(champ.statut)}>{champ.statut}</Badge>
                            </div>
                            <h3 className="champ-title">{champ.libelle}</h3>
                            <div className="champ-info">
                                <div className="info-item">
                                    <Calendar size={16} />
                                    <span>{new Date(champ.dateDeb).toLocaleDateString('fr-FR')}</span>
                                </div>
                                <div className="info-item">
                                    <MapPin size={16} />
                                    <span>{champ.lieu}</span>
                                </div>
                            </div>
                            <p className="champ-desc">{champ.description}</p>
                        </Card>
                    </Link>
                ))}
            </div>

            {filteredChampionnats.length === 0 && (
                <div className="no-results">Aucun championnat trouvé.</div>
            )}
        </div>
    );
};

export default Championnats;
