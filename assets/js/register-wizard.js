// Wizard de registro NDA: controla los 4 pasos (tipo de cuenta, rol, institucion, datos)
(function () {
    var form = document.getElementById('registerForm');
    if (!form) return;

    var fAccountType = document.getElementById('fAccountType');
    var fInstRole = document.getElementById('fInstRole');
    var fInstitucionId = document.getElementById('fInstitucionId');
    var fInstName = document.getElementById('fInstName');

    var wizInstCreate = document.getElementById('wizInstCreate');
    var wizInstJoin = document.getElementById('wizInstJoin');
    var wizInstList = document.getElementById('wizInstList');
    var wizInstSearch = document.getElementById('fInstSearch');
    var wizInstSelected = document.getElementById('wizInstSelected');

    var currentStep = 1;
    var accountType = 'general';
    var instRole = '';

    function showStep(step) {
        currentStep = step;
        document.querySelectorAll('.wiz-screen').forEach(function (el) {
            el.classList.toggle('on', parseInt(el.dataset.screen, 10) === step);
        });
        document.querySelectorAll('.wiz-step').forEach(function (el) {
            var n = parseInt(el.dataset.wizDot, 10);
            el.classList.toggle('on', n <= step);
        });
    }

    var typeCards = document.querySelectorAll('[data-account-type]');
    var next1 = document.querySelector('[data-next="1"]');
    typeCards.forEach(function (card) {
        card.addEventListener('click', function () {
            typeCards.forEach(function (c) { c.classList.remove('sel'); });
            card.classList.add('sel');
            accountType = card.dataset.accountType;
            fAccountType.value = accountType;
            next1.disabled = false;
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
        });
    }

    // Nombre de usuario: solo minusculas, numeros y guion bajo (debe
    // coincidir con AuthController::usernameError). Se sanea mientras se
    // escribe para no frustrar al usuario con errores de formato.
    var usernameRegex = /^[a-z0-9_]{3,20}$/;
    var usernameInput = document.getElementById('username-reg');
    if (usernameInput) {
        usernameInput.addEventListener('input', function () {
            var start = usernameInput.selectionStart;
            var cleaned = usernameInput.value.toLowerCase().replace(/[^a-z0-9_]/g, '');
            if (cleaned !== usernameInput.value) {
                usernameInput.value = cleaned;
                usernameInput.setSelectionRange(start - 1, start - 1);
            } else {
                usernameInput.value = cleaned;
            }
        });
    }

    form.addEventListener('submit', function (e) {
        var pwd = form.querySelector('input[name="password"]');
        var confirm = form.querySelector('input[name="password_confirm"]');
        var username = form.querySelector('input[name="username"]');
        if (username && !usernameRegex.test(username.value)) {
            e.preventDefault();
            ndaAlert('El nombre de usuario debe tener entre 3 y 20 caracteres: solo minúsculas, números y guion bajo.');
            username.focus();
            return false;
        }
        if (!passwordIsStrong(pwd.value)) {
            e.preventDefault();
            ndaAlert('Tu contraseña no cumple los requisitos: revisa la lista debajo del campo.');
            pwd.focus();
            return false;
        }
        if (pwd.value !== confirm.value) {
            e.preventDefault();
            ndaAlert('Las contraseñas no coinciden.');
            confirm.focus();
            return false;
        }
    });
})();
