// Wizard de registro NDA: controla los 4 pasos (tipo de cuenta, rol, institucion, datos)
(function () {
    var form = document.getElementById('registerForm');
    if (!form) return;

    var fAccountType = document.getElementById('fAccountType');
    var fInstRole = document.getElementById('fInstRole');
    var fInstitucionId = document.getElementById('fInstitucionId');
    var fInstName = document.getElementById('fInstName');
    var fInstEmail = document.getElementById('fInstEmail');

    var wizInstCreate = document.getElementById('wizInstCreate');
    var wizInstJoin = document.getElementById('wizInstJoin');
    var wizInstList = document.getElementById('wizInstList');
    var wizInstSearch = document.getElementById('fInstSearch');
    var wizInstSelected = document.getElementById('wizInstSelected');

    var currentStep = 1;
    var accountType = 'general';
    var instRole = '';

    var WIZ_STORAGE_KEY = 'ndaRegisterWizardState';
    function saveWizardState() {
        try {
            sessionStorage.setItem(WIZ_STORAGE_KEY, JSON.stringify({
                step: currentStep,
                accountType: accountType,
                instRole: instRole,
                institucionId: fInstitucionId.value,
                institucionName: wizInstSelected ? wizInstSelected.textContent.replace('Seleccionada: ', '') : '',
                fields: {
                    name: (form.querySelector('input[name="name"]') || {}).value || '',
                    username: (form.querySelector('input[name="username"]') || {}).value || '',
                    email: (form.querySelector('input[name="email"]') || {}).value || '',
                    inst_name: fInstName ? fInstName.value : '',
                    inst_tipo: (form.querySelector('select[name="inst_tipo"]') || {}).value || '',
                    inst_email: fInstEmail ? fInstEmail.value : '',
                    inst_director_email: (form.querySelector('input[name="inst_director_email"]') || {}).value || '',
                    inst_phone: (form.querySelector('input[name="inst_phone"]') || {}).value || '',
                    inst_address: (form.querySelector('input[name="inst_address"]') || {}).value || ''
                }
            }));
        } catch (e) { /* sessionStorage puede fallar en modo privado; no es grave */ }
    }
    function clearWizardState() {
        try { sessionStorage.removeItem(WIZ_STORAGE_KEY); } catch (e) { /* noop */ }
    }

    function showStep(step) {
        currentStep = step;
        document.querySelectorAll('.wiz-screen').forEach(function (el) {
            el.classList.toggle('on', parseInt(el.dataset.screen, 10) === step);
        });
        document.querySelectorAll('.wiz-step').forEach(function (el) {
            var n = parseInt(el.dataset.wizDot, 10);
            el.classList.toggle('on', n <= step);
        });
        saveWizardState();
    }

    // Cualquier cambio en un campo de texto/select del formulario
    // (nombre, username, correo, datos de la institución...) se guarda
    // tambien, no solo al cambiar de paso.
    form.addEventListener('input', saveWizardState);
    form.addEventListener('change', saveWizardState);

    var typeCards = document.querySelectorAll('[data-account-type]');
    var next1 = document.querySelector('[data-next="1"]');
    typeCards.forEach(function (card) {
        card.addEventListener('click', function () {
            typeCards.forEach(function (c) { c.classList.remove('sel'); });
            card.classList.add('sel');
            accountType = card.dataset.accountType;
            fAccountType.value = accountType;
            next1.disabled = false;
            saveWizardState();
        });
    });
    next1.addEventListener('click', function () {
        if (accountType === 'general') {
            showStep(4);
        } else {
            showStep(2);
        }
    });

    var roleCards = document.querySelectorAll('[data-inst-role]');
    var next2 = document.querySelector('[data-next="2"]');
    roleCards.forEach(function (card) {
        card.addEventListener('click', function () {
            roleCards.forEach(function (c) { c.classList.remove('sel'); });
            card.classList.add('sel');
            instRole = card.dataset.instRole;
            fInstRole.value = instRole;
            next2.disabled = false;
            saveWizardState();
        });
    });
    document.querySelector('[data-back="1"]').addEventListener('click', function () { showStep(1); });
    next2.addEventListener('click', function () {
        if (instRole === 'director') {
            wizInstCreate.style.display = 'block';
            wizInstJoin.style.display = 'none';
        } else {
            wizInstCreate.style.display = 'none';
            wizInstJoin.style.display = 'block';
        }
        showStep(3);
    });

    document.querySelector('[data-back="2"]').addEventListener('click', function () { showStep(2); });

    document.querySelector('[data-next="3"]').addEventListener('click', function () {
        if (instRole === 'director') {
            if (!fInstName.value.trim()) {
                fInstName.focus();
                ndaAlert('Ingresa el nombre de la institución.');
                return;
            }
            if (!fInstEmail.value.trim()) {
                fInstEmail.focus();
                ndaAlert('Ingresa el correo institucional: ahí te enviaremos el código de verificación.');
                return;
            }
        } else {
            if (!fInstitucionId.value) {
                ndaAlert('Selecciona la institución a la que perteneces.');
                return;
            }
        }
        showStep(4);
    });

    if (wizInstList) {
        wizInstList.addEventListener('click', function (e) {
            var item = e.target.closest('.wiz-inst-item');
            if (!item) return;
            document.querySelectorAll('.wiz-inst-item').forEach(function (i) { i.classList.remove('sel'); });
            item.classList.add('sel');
            fInstitucionId.value = item.dataset.id;
            wizInstSelected.textContent = 'Seleccionada: ' + item.dataset.name;
            saveWizardState();
        });
    }

    if (wizInstSearch) {
        wizInstSearch.addEventListener('input', function () {
            var q = wizInstSearch.value.toLowerCase();
            document.querySelectorAll('.wiz-inst-item').forEach(function (item) {
                var name = (item.dataset.name || '').toLowerCase();
                item.style.display = name.indexOf(q) !== -1 ? 'flex' : 'none';
            });
        });
    }

    document.querySelector('[data-back="3"]').addEventListener('click', function () {
        if (accountType === 'general') {
            showStep(1);
        } else {
            showStep(3);
        }
    });

    // Reglas de contraseña fuerte: deben coincidir con AuthController::passwordStrengthError.
    var pwdRules = {
        len: function (v) { return v.length >= 8; },
        upper: function (v) { return /[A-Z]/.test(v); },
        lower: function (v) { return /[a-z]/.test(v); },
        num: function (v) { return /[0-9]/.test(v); },
        sym: function (v) { return /[^A-Za-z0-9]/.test(v); }
    };

    function passwordIsStrong(v) {
        return Object.keys(pwdRules).every(function (key) { return pwdRules[key](v); });
    }

    var pwdInput = document.getElementById('pwd-reg');
    var pwdRulesList = document.getElementById('pwdRules');
    if (pwdInput && pwdRulesList) {
        pwdInput.addEventListener('input', function () {
            var v = pwdInput.value;
            Object.keys(pwdRules).forEach(function (key) {
                var li = pwdRulesList.querySelector('[data-rule="' + key + '"]');
                if (li) li.classList.toggle('ok', pwdRules[key](v));
            });
            checkPwdMatch();
        });
    }

    // Avisa en vivo si "Confirmar contraseña" coincide con "Contraseña",
    // en vez de que el usuario se entere recien al enviar el formulario.
    var pwdConfirmInput = document.getElementById('pwd-conf');
    var pwdConfirmHint = document.getElementById('pwdConfirmHint');
    function checkPwdMatch() {
        if (!pwdInput || !pwdConfirmInput || !pwdConfirmHint) return;
        if (!pwdConfirmInput.value) {
            setFieldHint(pwdConfirmHint, '', '');
            return;
        }
        var match = pwdInput.value === pwdConfirmInput.value;
        setFieldHint(pwdConfirmHint, match ? '✓ Las contraseñas coinciden' : '✗ Las contraseñas no coinciden', match ? 'ok' : 'taken');
    }
    if (pwdConfirmInput) {
        pwdConfirmInput.addEventListener('input', checkPwdMatch);
    }

    // Nombre de usuario: solo minusculas, numeros y guion bajo (debe
    // coincidir con AuthController::usernameError). Se sanea mientras se
    // escribe para no frustrar al usuario con errores de formato.
    var usernameRegex = /^[a-z0-9_]{3,20}$/;
    var usernameInput = document.getElementById('username-reg');

    function debounce(fn, wait) {
        var t;
        return function () {
            var args = arguments;
            clearTimeout(t);
            t = setTimeout(function () { fn.apply(null, args); }, wait);
        };
    }

    function setFieldHint(hintEl, text, cls) {
        if (!hintEl) return;
        hintEl.textContent = text;
        hintEl.className = 'wiz-hint' + (cls ? ' ' + cls : '');
        hintEl.style.display = text ? '' : 'none';
    }

    // Verificacion en vivo de username/correo contra
    // AuthController::checkAvailability, para avisar "ya está en uso"
    // mientras se escribe en vez de solo al enviar todo el formulario
    // (un choque ahi obligaba a rehacer los 4 pasos del wizard, porque
    // processRegister() solo guarda el error en sesion y redirige).
    function checkFieldAvailability(field, value, hintEl, onResult) {
        fetch('?url=register/check-availability&field=' + field + '&value=' + encodeURIComponent(value))
            .then(function (r) { return r.json(); })
            .then(function (data) {
                onResult(data.available === true);
                setFieldHint(hintEl, data.available ? '✓ Disponible' : (data.error || 'No disponible.'), data.available ? 'ok' : 'taken');
            })
            .catch(function () { onResult(null); });
    }

    var usernameHint = document.getElementById('usernameHint');
    var usernameHintDefault = usernameHint ? usernameHint.textContent : '';
    var usernameAvailable = null;
    var debouncedUsernameCheck = debounce(function (value) {
        checkFieldAvailability('username', value.toLowerCase(), usernameHint, function (ok) { usernameAvailable = ok; });
    }, 450);

    if (usernameInput) {
        usernameInput.addEventListener('input', function () {
            // No fuerza minusculas mientras se escribe (eso era lo que
            // "no dejaba escribir en mayuscula": cada letra en mayuscula
            // se convertia al toque). Se deja escribir tal cual, solo se
            // quitan simbolos invalidos (espacios, tildes, etc.); el
            // username igual se guarda en minusculas al enviar el
            // formulario, porque processRegister() ya hace strtolower().
            var start = usernameInput.selectionStart;
            var original = usernameInput.value;
            var cleaned = original.replace(/[^a-zA-Z0-9_]/g, '');
            if (cleaned !== original) {
                var removed = original.length - cleaned.length;
                usernameInput.value = cleaned;
                var pos = Math.max(0, start - removed);
                usernameInput.setSelectionRange(pos, pos);
            }

            usernameAvailable = null;
            if (usernameRegex.test(cleaned.toLowerCase())) {
                setFieldHint(usernameHint, 'Verificando disponibilidad...', 'checking');
                debouncedUsernameCheck(cleaned);
            } else {
                setFieldHint(usernameHint, usernameHintDefault, '');
            }
        });
    }

    var emailInput = document.getElementById('email-reg');
    var emailHint = document.getElementById('emailHint');
    var emailAvailable = null;
    var debouncedEmailCheck = debounce(function (value) {
        checkFieldAvailability('email', value, emailHint, function (ok) { emailAvailable = ok; });
    }, 450);

    if (emailInput) {
        emailInput.addEventListener('input', function () {
            var value = emailInput.value.trim();
            emailAvailable = null;
            if (value && emailInput.checkValidity()) {
                setFieldHint(emailHint, 'Verificando disponibilidad...', 'checking');
                debouncedEmailCheck(value);
            } else {
                setFieldHint(emailHint, '', '');
            }
        });
    }

    // El envío final va por fetch (no un submit normal) para que un error
    // del servidor (username/correo repetido, código MX inválido, etc.)
    // no navegue a otra página: si eso pasara, se pierde el paso del
    // wizard y todo lo ya escrito, que es justo lo que se queria evitar.
    var submitBtn = form.querySelector('button[type="submit"]');
    form.addEventListener('submit', function (e) {
        e.preventDefault();

        var pwd = form.querySelector('input[name="password"]');
        var confirm = form.querySelector('input[name="password_confirm"]');
        var username = form.querySelector('input[name="username"]');
        if (username && !usernameRegex.test(username.value.toLowerCase())) {
            ndaAlert('El nombre de usuario debe tener entre 3 y 20 caracteres: letras, números y guion bajo.');
            username.focus();
            return;
        }
        if (usernameAvailable === false) {
            ndaAlert('Ese nombre de usuario ya está en uso, elige otro.');
            username.focus();
            return;
        }
        if (emailAvailable === false) {
            ndaAlert('Ese correo ya está registrado.');
            emailInput.focus();
            return;
        }
        if (!passwordIsStrong(pwd.value)) {
            ndaAlert('Tu contraseña no cumple los requisitos: revisa la lista debajo del campo.');
            pwd.focus();
            return;
        }
        if (pwd.value !== confirm.value) {
            ndaAlert('Las contraseñas no coinciden.');
            confirm.focus();
            return;
        }
        // El <input required> no alcanza porque el form tiene novalidate
        // (necesario para que el submit por fetch controle el flujo), asi
        // que hay que chequear el checkbox de terminos a mano.
        var termsInput = form.querySelector('input[name="terms"]');
        if (termsInput && !termsInput.checked) {
            ndaAlert('Debes aceptar los Términos y la Política de Privacidad para crear tu cuenta.');
            termsInput.focus();
            return;
        }

        var originalBtnText = submitBtn ? submitBtn.textContent : '';
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.textContent = 'Creando cuenta...';
        }

        fetch(form.action, { method: 'POST', body: new FormData(form) })
            .then(function (r) { return r.json(); })
            .then(function (data) {
                if (data.success) {
                    clearWizardState();
                    window.location.href = data.redirect;
                    return;
                }
                ndaAlert(data.error || 'No se pudo crear la cuenta, intenta de nuevo.');
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalBtnText;
                }
            })
            .catch(function () {
                ndaAlert('No se pudo conectar con el servidor. Revisa tu conexión e intenta de nuevo.');
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalBtnText;
                }
            });
    });

    // Restaura lo guardado por saveWizardState() (ver arriba) al cargar
    // la página, si había algo pendiente de una visita anterior/recarga.
    (function restoreWizardState() {
        var raw;
        try { raw = sessionStorage.getItem(WIZ_STORAGE_KEY); } catch (e) { return; }
        if (!raw) return;
        var state;
        try { state = JSON.parse(raw); } catch (e) { return; }
        if (!state) return;

        var f = state.fields || {};
        function setVal(selector, val) {
            var el = form.querySelector(selector);
            if (el && val) el.value = val;
        }
        setVal('input[name="name"]', f.name);
        setVal('input[name="username"]', f.username);
        setVal('input[name="email"]', f.email);
        setVal('input[name="inst_name"]', f.inst_name);
        setVal('select[name="inst_tipo"]', f.inst_tipo);
        setVal('input[name="inst_email"]', f.inst_email);
        setVal('input[name="inst_director_email"]', f.inst_director_email);
        setVal('input[name="inst_phone"]', f.inst_phone);
        setVal('input[name="inst_address"]', f.inst_address);

        if (state.accountType) {
            accountType = state.accountType;
            fAccountType.value = accountType;
            typeCards.forEach(function (c) { c.classList.toggle('sel', c.dataset.accountType === accountType); });
            next1.disabled = false;
        }
        if (state.instRole) {
            instRole = state.instRole;
            fInstRole.value = instRole;
            roleCards.forEach(function (c) { c.classList.toggle('sel', c.dataset.instRole === instRole); });
            next2.disabled = false;
            if (wizInstCreate && wizInstJoin) {
                wizInstCreate.style.display = instRole === 'director' ? 'block' : 'none';
                wizInstJoin.style.display = instRole === 'director' ? 'none' : 'block';
            }
        }
        if (state.institucionId) {
            fInstitucionId.value = state.institucionId;
            if (wizInstSelected && state.institucionName) {
                wizInstSelected.textContent = 'Seleccionada: ' + state.institucionName;
            }
            var item = wizInstList ? wizInstList.querySelector('[data-id="' + state.institucionId + '"]') : null;
            if (item) {
                document.querySelectorAll('.wiz-inst-item').forEach(function (i) { i.classList.remove('sel'); });
                item.classList.add('sel');
            }
        }

        if (usernameInput) usernameInput.dispatchEvent(new Event('input'));
        if (emailInput) emailInput.dispatchEvent(new Event('input'));

        if (state.step) showStep(state.step);
    })();
})();
