function formhash(form, password) {
    // Create a new element input, this will be our hashed password field.
    var p = document.createElement("input");

    // Add the new element to our form.
    form.appendChild(p);
    p.name = "p";
    p.type = "hidden";
    p.value = hex_sha512(password.value);

    // Make sure the plaintext password doesn't get sent.
    password.value = "";

    // Finally submit the form.
    form.submit();
}

function regformhash(form, password, conf) {
     // Check each field has a value
    if (password.value == ''  ||
          conf.value == '') {

        show_notificacion_warning('Debes proveer todos los datos solicitados.');
        return false;
    }


    // Check that the password is sufficiently long (min 6 chars)
    // The check is duplicated below, but this is included to give more
    // specific guidance to the user
    if (password.value.length < 6) {
        show_notificacion_warning('Contraseña debe tener almenos 6 caracteres de largo.');
        form.password.focus();
        return false;
    }

    // At least one number, one lowercase and one uppercase letter
    // At least six characters

    var re = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/;
    if (!re.test(password.value)) {
        show_notificacion_warning('Teclee al menos un numero, una minuscula y una mayuscula.');
        return false;
    }

    // Check password and confirmation are the same
    if (password.value != conf.value) {
        show_notificacion_warning('La confirmación y la contraseña no son iguales.');
        form.password.focus();
        return false;
    }

    // Create a new element input, this will be our hashed password field.
    var p = document.createElement("input");

    // Add the new element to our form.
    form.appendChild(p);
    p.name = "p";
    p.type = "hidden";
    p.value = hex_sha512(password.value);

    // Make sure the plaintext password doesn't get sent.
    password.value = "";
    conf.value = "";

    // Finally submit the form.
    //form.submit();
    return p.value;
}
