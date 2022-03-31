describe("Sign up", () => {
    before(() => {
        cy.recreateDatabase();
    });
    it("[SU-1] shows the sign-up page", () => {
        cy.visit("/sign-up");
        cy.get(`[data-cy="sign-up"]`).should("exist");
        cy.get(`[data-cy="sign-up__email"]`).should("exist");
        cy.get(`[data-cy="sign-up__password"]`).should("exist");
    });

    it("[SU-2] allows the user to sign-up correctly", () => {
        cy.visit("/sign-up");
        cy.get(`[data-cy="sign-up__email"]`).type("student@salle.url.edu");
        cy.get(`[data-cy="sign-up__password"]`).type("Test001");
        cy.get(`[data-cy="sign-up__repeatPassword"]`).type("Test001");
        cy.get(`[data-cy="sign-in__birthday"]`).type("1996-11-18");
        cy.get(`[data-cy="sign-up__btn"]`).click();
        cy.location('pathname').should('eq', '/sign-in')
    });

    it("[SU-3] shows error when email does not have salle.url.edu", () => {
        cy.visit("/sign-up");
        cy.get(`[data-cy="sign-up__email"]`).type("student@gmail.com");
        cy.get(`[data-cy="sign-up__password"]`).type("Test001");
        cy.get(`[data-cy="sign-up__repeatPassword"]`).type("Test001");
        cy.get(`[data-cy="sign-in__birthday"]`).type("1996-11-18");
        cy.get(`[data-cy="sign-up__btn"]`).click();
        cy.get(`[data-cy="sign-up__wrongEmail"]`).should("exist");
        cy.get(`[data-cy="sign-up__wrongEmail"]`).invoke('text').should("eq", "Only emails from the domain @salle.url.edu are accepted");
    });

    it("[SU-4] shows error when email is not a valid email", () => {
        cy.visit("/sign-up");
        cy.get(`[data-cy="sign-up__email"]`).type("student");
        cy.get(`[data-cy="sign-up__password"]`).type("Test001");
        cy.get(`[data-cy="sign-up__repeatPassword"]`).type("Test001");
        cy.get(`[data-cy="sign-in__birthday"]`).type("1996-11-18");
        cy.get(`[data-cy="sign-up__btn"]`).click();
        cy.get(`[data-cy="sign-up__wrongEmail"]`).should("exist");
        cy.get(`[data-cy="sign-up__wrongEmail"]`).invoke('text').should("eq", "The email address is not valid");
    });

    it("[SU-5] shows error when password has less than 6 characters", () => {
        cy.visit("/sign-up");
        cy.get(`[data-cy="sign-up__email"]`).type("student@salle.url.edu");
        cy.get(`[data-cy="sign-up__password"]`).type("Test");
        cy.get(`[data-cy="sign-up__repeatPassword"]`).type("Test");
        cy.get(`[data-cy="sign-in__birthday"]`).type("1996-11-18");
        cy.get(`[data-cy="sign-up__btn"]`).click();
        cy.get(`[data-cy="sign-up__wrongPassword"]`).should("exist");
        cy.get(`[data-cy="sign-up__wrongPassword"]`).invoke('text').should("eq", "The password must contain at least 6 characters");
    });

    it("[SU-6] shows error when password does not follow correct format", () => {
        cy.visit("/sign-up");
        cy.get(`[data-cy="sign-up__email"]`).type("student@salle.url.edu");
        cy.get(`[data-cy="sign-up__password"]`).type("TestTest");
        cy.get(`[data-cy="sign-up__repeatPassword"]`).type("TestTest");
        cy.get(`[data-cy="sign-in__birthday"]`).type("1996-11-18");
        cy.get(`[data-cy="sign-up__btn"]`).click();
        cy.get(`[data-cy="sign-up__wrongPassword"]`).should("exist");
        cy.get(`[data-cy="sign-up__wrongPassword"]`).invoke('text').should("eq", "The password must contain both upper and lower case letters and numbers");
    });

    it("[SU-7] shows error when passwords do not match", () => {
        cy.visit("/sign-up");
        cy.get(`[data-cy="sign-up__email"]`).type("student@salle.url.edu");
        cy.get(`[data-cy="sign-up__password"]`).type("TestTest");
        cy.get(`[data-cy="sign-up__repeatPassword"]`).type("Test");
        cy.get(`[data-cy="sign-in__birthday"]`).type("1996-11-18");
        cy.get(`[data-cy="sign-up__btn"]`).click();
        cy.get(`[data-cy="sign-up__wrongPassword"]`).should("exist");
        cy.get(`[data-cy="sign-up__wrongPassword"]`).invoke('text').should("eq", "Passwords do not match");
    });

    it("[SU-8] shows error when user is underage", () => {
        cy.visit("/sign-up");
        cy.get(`[data-cy="sign-up__email"]`).type("student@salle.url.edu");
        cy.get(`[data-cy="sign-up__password"]`).type("Test1234");
        cy.get(`[data-cy="sign-up__repeatPassword"]`).type("Test1234");
        cy.get(`[data-cy="sign-in__birthday"]`).type("2020-11-18");
        cy.get(`[data-cy="sign-up__btn"]`).click();
        cy.get(`[data-cy="sign-up__wrongBirthday"]`).should("exist");
        cy.get(`[data-cy="sign-up__wrongBirthday"]`).invoke('text').should("eq", "Sorry, you are underage");
    });

    it("[SU-9] shows error when birthday is invalid", () => {
        cy.visit("/sign-up");
        cy.get(`[data-cy="sign-up__email"]`).type("student@salle.url.edu");
        cy.get(`[data-cy="sign-up__password"]`).type("Test1234");
        cy.get(`[data-cy="sign-up__repeatPassword"]`).type("Test1234");
        cy.get(`[data-cy="sign-in__birthday"]`).type("1996-11-46");
        cy.get(`[data-cy="sign-up__btn"]`).click();
        cy.get(`[data-cy="sign-up__wrongBirthday"]`).should("exist");
        cy.get(`[data-cy="sign-up__wrongBirthday"]`).invoke('text').should("eq", "Birthday is invalid");
    });

    it("[SU-10] shows email and birthday when password is incorrect", () => {
        let email = "student@salle.url.edu";
        let password = "p";
        let birthday = "1996-11-46"

        cy.visit("/sign-up");
        cy.get(`[data-cy="sign-up__email"]`).type(email);
        cy.get(`[data-cy="sign-up__password"]`).type(password);
        cy.get(`[data-cy="sign-up__repeatPassword"]`).type(password);
        cy.get(`[data-cy="sign-in__birthday"]`).type(birthday);
        cy.get(`[data-cy="sign-up__btn"]`).click();
        cy.get(`[data-cy="sign-up__email"]`).invoke('val').should("eq", email);
        cy.get(`[data-cy="sign-in__birthday"]`).invoke('val').should("eq", birthday);
    });

    it("[SU-11] allows user to sign-up without specifying birthday", () => {
        cy.visit("/sign-up");
        cy.get(`[data-cy="sign-up__email"]`).type("student2@salle.url.edu");
        cy.get(`[data-cy="sign-up__password"]`).type("Test1234");
        cy.get(`[data-cy="sign-up__repeatPassword"]`).type("Test1234");
        cy.get(`[data-cy="sign-up__btn"]`).click();
        cy.location('pathname').should('eq', '/sign-in')
    });
});
