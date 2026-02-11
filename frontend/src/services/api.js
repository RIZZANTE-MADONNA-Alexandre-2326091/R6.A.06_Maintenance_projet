import { CHAMPIONNATS, SPORTS, EPREUVES } from './mockData';

export const api = {
    getSports: async () => {
        // Simulate API delay
        await new Promise(resolve => setTimeout(resolve, 300));
        return SPORTS;
    },

    getChampionnats: async () => {
        await new Promise(resolve => setTimeout(resolve, 500));
        return CHAMPIONNATS.map(c => ({
            ...c,
            sport: SPORTS.find(s => s.id === c.sportId)
        }));
    },

    getChampionnatById: async (id) => {
        await new Promise(resolve => setTimeout(resolve, 400));
        const championnat = CHAMPIONNATS.find(c => c.id === parseInt(id));
        if (!championnat) return null;

        const sport = SPORTS.find(s => s.id === championnat.sportId);
        const epreuves = EPREUVES.filter(e => e.competId === championnat.id);

        return { ...championnat, sport, epreuves };
    }
};
