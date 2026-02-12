describe('UGSEL 35 - API Handling Tests', () => {
    it('should display a loading state while fetching sports', () => {
        cy.intercept('GET', '/api/sports', {
            delay: 1000,
            body: [{ id: 1, name: 'Football', type: 'equipe' }]
        }).as('getSports');

        cy.visit('/sports');
        cy.get('.loader-container').should('be.visible');
        cy.wait('@getSports');
        cy.get('.loader-container').should('not.exist');
    });

    it('should display an error message when API fails', () => {
        cy.intercept('GET', '/api/sports', {
            statusCode: 500,
            body: { message: 'Internal Server Error' }
        }).as('getSportsError');

        cy.visit('/sports');
        cy.wait('@getSportsError');
        cy.get('.error-message').should('be.visible').and('contain', 'Impossible de charger les sports');
    });

    it('should display empty state when no sports are returned', () => {
        cy.intercept('GET', '/api/sports', {
            body: []
        }).as('getSportsEmpty');

        cy.visit('/sports');
        cy.wait('@getSportsEmpty');
        cy.get('.empty-state').should('be.visible').and('contain', 'Aucun sport disponible');
    });

    it('should display empty state when no championnats are returned', () => {
        cy.intercept('GET', '/api/championnats', {
            body: []
        }).as('getChampionnatsEmpty');

        cy.visit('/championnats');
        cy.wait('@getChampionnatsEmpty');
        cy.get('.no-results').should('be.visible').and('contain', 'Aucun championnat disponible');
    });
});
