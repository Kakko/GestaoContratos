function changeUser() {
    document.getElementById('initialPass').toggleAttribute('hidden', false);
    document.getElementById('pass').toggleAttribute('hidden', true);

    document.getElementById('initialUser').toggleAttribute('hidden', true);
    document.getElementById('user').toggleAttribute('hidden', false);
}

function changePass() {
    document.getElementById('initialUser').toggleAttribute('hidden', false);
    document.getElementById('user').toggleAttribute('hidden', true);

    document.getElementById('initialPass').toggleAttribute('hidden', true);
    document.getElementById('pass').toggleAttribute('hidden', false);
}