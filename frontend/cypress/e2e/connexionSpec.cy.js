describe('The Connexion Page', () => {
  it('successfully loads', () => {
    cy.visit('http://localhost:5173/connexion') // change URL to match your dev URL
  })
});

// Vérification authentification
Cypress.Commands.add('connexion', (email, password) => {
  cy.session(
      email,
      () => {
        cy.visit('/login')
        cy.get('input[name=email]').type(email)
        cy.get('input[name=password]').type(`${password}{enter}`, { log: false })
        cy.url().should('include', '/championnats')
        cy.get('h1').should('contain', email)
      },
      {
        validate: () => {
          cy.getCookie('your-session-cookie').should('exist')
        },
      }
  )
});
