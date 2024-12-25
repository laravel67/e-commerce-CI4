function logout() {
    const $logoutForm = $('#logout-form');
    if ($logoutForm.length) {
        $logoutForm.submit();
    } else {
        console.error('Logout form not found.');
    }
}