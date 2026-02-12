

export const api = {
    getSports: async () => {
        const response = await fetch('/api/sports');
        if (!response.ok) throw new Error('Failed to fetch sports');
        const data = await response.json();
        // API Platform returns data in 'hydra:member' or direct array depending on config.
        // Assuming standard JSON-LD or simple JSON. Let's handle both.
        return data['hydra:member'] || data;
    },

    getChampionnats: async () => {
        const response = await fetch('/api/championnats');
        if (!response.ok) throw new Error('Failed to fetch championnats');
        const data = await response.json();
        return data['hydra:member'] || data;
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
    }
};
