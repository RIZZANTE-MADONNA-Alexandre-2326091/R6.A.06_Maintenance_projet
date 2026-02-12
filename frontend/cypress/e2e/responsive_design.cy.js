describe('UGSEL 35 - Responsive Design Tests', () => {
    const viewports = ['iphone-xr', 'ipad-2', [1280, 720]];

    viewports.forEach((viewport) => {
        it(`should look good on ${Array.isArray(viewport) ? viewport.join('x') : viewport}`, () => {
            if (Array.isArray(viewport)) {
                cy.viewport(viewport[0], viewport[1]);
            } else {
                cy.viewport(viewport);
            }

            cy.visit('/');
            cy.get('.header').should('be.visible');

            // On mobile, check if menu toggle is visible
            if (viewport === 'iphone-xr') {
                cy.get('.menu-toggle').should('be.visible');
                cy.get('nav').should('not.have.class', 'open');
            } else if (Array.isArray(viewport) && viewport[0] >= 1024) {
                cy.get('.menu-toggle').should('not.be.visible');
                cy.get('nav').should('be.visible');
            }

            cy.get('.footer').should('be.visible');
        });
    });

    it('should adapt the sports grid layout', () => {
        cy.viewport('iphone-xr');
        cy.visit('/sports');
        // On small screens, cards should be wide (likely 100% or near)
        cy.get('.sport-card').first().should('be.visible');

        cy.viewport(1280, 720);
        // On large screens, cards should be in a grid
        cy.get('.sports-grid').should('have.css', 'display', 'grid');
    });
});
