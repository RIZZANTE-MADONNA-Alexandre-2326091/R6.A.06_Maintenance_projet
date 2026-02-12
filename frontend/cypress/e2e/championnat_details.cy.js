describe('UGSEL 35 - Championnat Details Tests', () => {
    const mockChampionnat = {
        id: 1,
        name: "Championnat Test de l'Espace",
        competitions: [
            {
                id: 10,
                name: "Compétition de Foot Intergalactique",
                epreuves: [
                    {
                        id: 101,
                        name: "Finale Mars vs Jupiter",
                        sport: { name: "Football", type: "equipe" }
                    }
                ]
            }
        ]
    };

    it('should display the details of a championnat', () => {
        cy.intercept('GET', '/api/championnats/1', {
            body: mockChampionnat
        }).as('getChampDetail');

        cy.visit('/championnats/1');
        cy.wait('@getChampDetail');

        cy.get('h1').should('contain', "Championnat Test de l'Espace");
        cy.get('.competition-title').should('contain', "Compétition de Foot Intergalactique");
        cy.get('.epreuve-card').should('have.length', 1);
        cy.get('.epreuve-card h3').should('contain', "Finale Mars vs Jupiter");
        cy.get('.badge').should('contain', "Football");
    });

    it('should navigate back to championnats list', () => {
        cy.intercept('GET', '/api/championnats/1', { body: mockChampionnat });
        cy.visit('/championnats/1');

        cy.get('.back-link').click();
        cy.url().should('include', '/championnats');
        cy.get('h1').should('contain', 'Championnats');
    });

    it('should show not found message if championnat does not exist', () => {
        cy.intercept('GET', '/api/championnats/999', {
            statusCode: 404,
            body: null
        }).as('getChamp404');

        cy.visit('/championnats/999');
        cy.wait('@getChamp404');
        cy.get('.not-found').should('be.visible').and('contain', 'Championnat introuvable');
    });
});
