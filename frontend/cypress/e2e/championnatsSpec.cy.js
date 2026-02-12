describe('The Championnat Page', () => {
  it('successfully loads', () => {
    cy.visit('http://localhost:5173/championnats') // change URL to match your dev URL
  })
});

cy.get('championnats-page').should('exist').should('be.visible');
cy.visit('http://localhost:5173/championnats/1');
cy.get('main-content container').should('exist').should('be.visible');

