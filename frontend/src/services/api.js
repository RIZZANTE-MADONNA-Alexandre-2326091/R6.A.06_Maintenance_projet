

export const api = {
    getSports: async () => {
        const response = await fetch('/api/sports');
        if (!response.ok) throw new Error('Failed to fetch sports');
        const data = await response.json();
        if (Array.isArray(data)) return data;
        if (data['hydra:member']) return data['hydra:member'];
        if (data['member']) return data['member'];
        return [];
    },

    getChampionnats: async () => {
        const response = await fetch('/api/championnats');
        if (!response.ok) throw new Error('Failed to fetch championnats');
        const data = await response.json();
        if (Array.isArray(data)) return data;
        if (data['hydra:member']) return data['hydra:member'];
        if (data['member']) return data['member'];
        return [];
    },

    getCompetitions: async () => {
        const response = await fetch('/api/competitions');
        if (!response.ok) throw new Error('Failed to fetch competitions');
        const data = await response.json();
        if (Array.isArray(data)) return data;
        if (data['hydra:member']) return data['hydra:member'];
        if (data['member']) return data['member'];
        return [];
    },

    getEpreuves: async () => {
        const response = await fetch('/api/epreuves');
        if (!response.ok) throw new Error('Failed to fetch epreuves');
        const data = await response.json();
        if (Array.isArray(data)) return data;
        if (data['hydra:member']) return data['hydra:member'];
        if (data['member']) return data['member'];
        return [];
    },

    getChampionnatById: async (id) => {
        try {
            const response = await fetch(`/api/championnats/${id}`);
            if (!response.ok) throw new Error('Failed to fetch championnat details');
            return await response.json();
        } catch (error) {
            console.error('Error fetching championnat details:', error);
            return null;
        }
    },

    // Creation methods
    createSport: async (data) => {
        const response = await fetch('/api/sports', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data),
        });
        if (!response.ok) throw new Error('Failed to create sport');
        return await response.json();
    },

    createChampionnat: async (data) => {
        const response = await fetch('/api/championnats', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data),
        });
        if (!response.ok) throw new Error('Failed to create championnat');
        return await response.json();
    },

    createCompetition: async (data) => {
        const response = await fetch('/api/competitions', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data),
        });
        if (!response.ok) throw new Error('Failed to create competition');
        return await response.json();
    },

    createEpreuve: async (data) => {
        const response = await fetch('/api/epreuves', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data),
        });
        if (!response.ok) throw new Error('Failed to create epreuve');
        return await response.json();
    },

    // Update methods
    updateSport: async (id, data) => {
        const response = await fetch(`/api/sports/${id}`, {
            method: 'PATCH',
            headers: { 'Content-Type': 'application/merge-patch+json' },
            body: JSON.stringify(data),
        });
        if (!response.ok) throw new Error('Failed to update sport');
        return await response.json();
    },

    updateChampionnat: async (id, data) => {
        const response = await fetch(`/api/championnats/${id}`, {
            method: 'PATCH',
            headers: { 'Content-Type': 'application/merge-patch+json' },
            body: JSON.stringify(data),
        });
        if (!response.ok) throw new Error('Failed to update championnat');
        return await response.json();
    },

    updateCompetition: async (id, data) => {
        const response = await fetch(`/api/competitions/${id}`, {
            method: 'PATCH',
            headers: { 'Content-Type': 'application/merge-patch+json' },
            body: JSON.stringify(data),
        });
        if (!response.ok) throw new Error('Failed to update competition');
        return await response.json();
    },

    updateEpreuve: async (id, data) => {
        const response = await fetch(`/api/epreuves/${id}`, {
            method: 'PATCH',
            headers: { 'Content-Type': 'application/merge-patch+json' },
            body: JSON.stringify(data),
        });
        if (!response.ok) throw new Error('Failed to update epreuve');
        return await response.json();
    },

    deleteSport: async (id) => {
        const response = await fetch(`/api/sports/${id}`, { method: 'DELETE' });
        if (!response.ok) throw new Error('Failed to delete sport');
        return true;
    },

    deleteChampionnat: async (id) => {
        const response = await fetch(`/api/championnats/${id}`, { method: 'DELETE' });
        if (!response.ok) throw new Error('Failed to delete championnat');
        return true;
    },

    deleteCompetition: async (id) => {
        const response = await fetch(`/api/competitions/${id}`, { method: 'DELETE' });
        if (!response.ok) throw new Error('Failed to delete competition');
        return true;
    },

    deleteEpreuve: async (id) => {
        const response = await fetch(`/api/epreuves/${id}`, { method: 'DELETE' });
        if (!response.ok) throw new Error('Failed to delete epreuve');
        return true;
    }
};
