import React from 'react';
import { BrowserRouter, Routes, Route, Navigate } from 'react-router-dom';
import Layout from './layouts/Layout';
import Championnats from './pages/Championnats';
import ChampionnatDetails from './pages/ChampionnatDetails';
import Sports from './pages/Sports';

// Placeholder components for routes not yet implemented
const Home = () => (
  <div style={{ textAlign: 'center', padding: '4rem 0' }}>
    <h1 style={{ fontSize: '2.5rem', marginBottom: '1rem', color: 'var(--primary)' }}>Bienvenue sur UGSEL 35</h1>
    <p style={{ color: 'var(--text-muted)', fontSize: '1.25rem' }}>Portail des compétitions scolaires</p>
  </div>
);

const Connexion = () => (
  <div style={{ textAlign: 'center', padding: '4rem 0' }}>
    <h1>Se connecter</h1>
  </div>
);

function App() {
  return (
    <BrowserRouter>
      <Routes>
        <Route path="/" element={<Layout />}>
          <Route index element={<Home />} />
          <Route path="sports" element={<Sports />} />
          <Route path="championnats" element={<Championnats />} />
          <Route path="championnats/:id" element={<ChampionnatDetails />} />
          <Route path="connexion" element={<Connexion />} />
          <Route path="*" element={<Navigate to="/" replace />} />
        </Route>
      </Routes>
    </BrowserRouter>
  );
}

export default App;
