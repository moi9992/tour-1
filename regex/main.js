    // Expressions régulières pour la validation
        const validators = {
            // Nom d'utilisateur: 3-16 caractères, lettres, chiffres, underscore, pas d'espace
            username: /^[a-zA-Z0-9_]{3,16}$/,
            
            // Email: format prenom.nom@domaine.extension (2-4 lettres)
            email: /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/,
            
            // Mot de passe: 8 caractères min, 1 maj, 1 min, 1 chiffre, 1 caractère spécial
            password: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/,
            
            // Téléphone français: format flexible
            phone: /^(?:(?:\+|00)33|0)\s*[1-9](?:[\s.-]*\d{2}){4}$/
        };

        // Fonction de validation
        function validateField(field, value) {
            const regex = validators[field];
            if (!regex) return false;
            return regex.test(value);
        }

        // Fonction pour mettre à jour le résultat
        function updateResult(input) {
            const field = input.dataset.field;
            const value = input.value;
            const row = input.closest('tr');
            const resultCell = row.querySelector('.result');
            
            const isValid = validateField(field, value);
            
            if (isValid) {
                resultCell.innerHTML = '<span class="check">✓</span>';
            } else {
                resultCell.innerHTML = '<span class="cross">✗</span>';
            }
        }

        // Ajouter les écouteurs d'événements sur tous les inputs
        document.querySelectorAll('input[data-field]').forEach(input => {
            input.addEventListener('input', function() {
                updateResult(this);
            });
            
            // Validation initiale
            updateResult(input);
        });
