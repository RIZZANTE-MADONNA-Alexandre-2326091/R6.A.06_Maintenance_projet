describe('UGSEL 35 - Application Tests', () => {
    beforeEach(() => {
        // Visit the home page before each test
        cy.visit('/');
    });

    it('should load the home page correctly', () => {
        cy.get('h1').should('contain', 'Bienvenue sur UGSEL 35');
        cy.get('p').should('contain', 'Portail des compétitions scolaires');
    });

    it('should navigate to the Sports page', () => {
        cy.get('nav').contains('Sports').click();
        cy.url().should('include', '/sports');
        cy.get('h1.sports-title').should('be.visible').and('contain', 'Nos Sports');

        // Wait for the loader to disappear or for data to appear
        cy.get('.sports-grid').should('be.visible');

        // Check if there are sports or the empty state
        cy.get('body').then(($body) => {
            if ($body.find('.sport-card').length > 0) {
                cy.get('.sport-card').should('have.length.at.least', 1);
            } else {
                cy.get('.empty-state').should('be.visible');
            }
        });
    });

    it('should navigate to the Championnats page', () => {
        cy.get('nav').contains('Championnats').click();
        cy.url().should('include', '/championnats');
        cy.get('h1.sports-title').should('be.visible').and('contain', 'Championnats');

        cy.get('.championnats-grid').should('be.visible');

        // Check if there are championnats or the empty state
        cy.get('body').then(($body) => {
            if ($body.find('.championnat-card').length > 0) {
                cy.get('.championnat-card').should('have.length.at.least', 1);

                // Test clicking on a championnat card if it exists
                cy.get('.championnat-card').first().click();
                cy.url().should('match', /\/championnats\/\d+/);
            } else {
                cy.get('.no-results').should('be.visible');
            }
        });
    });

    it('should navigate to the Connexion page', () => {
        cy.get('nav').contains('Connexion').click();
        cy.url().should('include', '/connexion');
        cy.get('h1').should('contain', 'Se connecter');
    });

    it('should have a working mobile menu', () => {
        // Set viewport to a mobile size
        cy.viewport('iphone-xr');

        // Nav should not be visible initially
        cy.get('nav').should('not.have.class', 'open');

        // Click toggle button
        cy.get('.menu-toggle').click();

        // Nav should be visible
        cy.get('nav').should('have.class', 'open');

        // Click a link and check if menu closes
        cy.get('nav').contains('Sports').click();
        cy.get('nav').should('not.have.class', 'open');
        cy.url().should('include', '/sports');
    });

    it('should verify the footer information', () => {
        const currentYear = new Date().getFullYear();
        cy.get('footer').should('contain', `© ${currentYear} UGSEL 35 - Comité Départemental`);
    });
});
