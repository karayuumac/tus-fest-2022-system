describe('ログイン画面', () => {
  before(() => {
    cy.exec('yarn run db:reset')
  })

  it('表示される', () => {
    cy.visit('/login')
  })

  it('ログインできる', () => {
    cy.visit('/login')
    cy.get('input[type="email"]').type('test@example.com')
    cy.get('input[type="password"]').type('password')
    cy.get('[data-cy="button"]').click()

    cy.location('pathname').should('eq', '/')
  })
})
