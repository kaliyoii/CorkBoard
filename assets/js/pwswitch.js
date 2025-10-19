function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const icon = field.nextElementSibling.querySelector('ion-icon');
    
    if (field.type === 'password') {
        field.type = 'text';
        icon.name = 'eye-outline';
    } else {
        field.type = 'password';
        icon.name = 'eye-off-outline';
    }
}