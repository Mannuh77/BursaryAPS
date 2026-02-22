    function validateForm() {
        let isValid = true;
        const nameRegex = /^[a-zA-Z\s\-]+$/;

        const validators = {
            surname: value => value.trim() !== '' && nameRegex.test(value),
            firstName: value => value.trim() !== '' && nameRegex.test(value),
            otherNames: value => value === '' || nameRegex.test(value),
            dob: value => {
                if (!value) return false;
                const dobDate = new Date(value);
                const today = new Date();
                const age = today.getFullYear() - dobDate.getFullYear();
                const monthDiff = today.getMonth() - dobDate.getMonth();
                const dayDiff = today.getDate() - dobDate.getDate();

                if (monthDiff < 0 || (monthDiff === 0 && dayDiff < 0)) {
                    return age - 1 >= 16 && age - 1 <= 35;
                }
                return age >= 16 && age <= 35;
            },
            gender: value => value !== '',
            idNumber: value => /^[0-9]{8,12}$/.test(value),
            email: value => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value),
            postalAddress: value => value.trim() !== '',
            postalCode: value => /^[0-9]{5}$/.test(value),
            subCounty: value => value.trim() !== '' && nameRegex.test(value),
            ward: value => value !== '',
            location: value => value.trim() !== '' && nameRegex.test(value),
            subLocation: value => value.trim() !== '' && nameRegex.test(value),
            village: value => value.trim() !== '' && nameRegex.test(value),
            pollingStation: value => value.trim() !== '' && nameRegex.test(value),
        };

        const errorMessages = {
            surname: 'Surname is required and must contain only letters, spaces or hyphens',
            firstName: 'First name is required and must contain only letters, spaces or hyphens',
            otherNames: 'Other names must contain only letters, spaces or hyphens',
            dob: 'Applicant must be between 16 and 35 years old',
            gender: 'Please select a gender',
            idNumber: 'Enter a valid ID number (8–12 digits)',
            email: 'Enter a valid email address',
            postalAddress: 'Postal address is required',
            postalCode: 'Postal code must be 5 digits',
            subCounty: 'Sub-county is required and must contain only letters, spaces or hyphens',
            ward: 'Please select a ward',
            location: 'Location is required and must contain only letters, spaces or hyphens',
            subLocation: 'Sub-location is required and must contain only letters, spaces or hyphens',
            village: 'Village is required and must contain only letters, spaces or hyphens',
            pollingStation: 'Polling station is required and must contain only letters, spaces or hyphens'
        };

        // Clear all previous errors
        document.querySelectorAll('.error-message').forEach(el => el.textContent = '');

        for (let field in validators) {
            const input = document.getElementById(field);
            const value = input.value.trim();
            const isFieldValid = validators[field](value);
            const errorSpan = document.getElementById(`${field}-error`);

            if (!isFieldValid) {
                errorSpan.textContent = errorMessages[field] || 'Invalid input';
                input.style.borderColor = 'red';
                isValid = false;
            } else {
                input.style.borderColor = 'green';
            }
        }

        return isValid;
    }

    document.addEventListener('DOMContentLoaded', () => {
        const nameRegex = /^[a-zA-Z\s\-]+$/;

        const validators = {
            surname: value => value.trim() !== '' && nameRegex.test(value),
            firstName: value => value.trim() !== '' && nameRegex.test(value),
            otherNames: value => value === '' || nameRegex.test(value),
            dob: value => {
                if (!value) return false;
                const dobDate = new Date(value);
                const today = new Date();
                const age = today.getFullYear() - dobDate.getFullYear();
                const monthDiff = today.getMonth() - dobDate.getMonth();
                const dayDiff = today.getDate() - dobDate.getDate();

                if (monthDiff < 0 || (monthDiff === 0 && dayDiff < 0)) {
                    return age - 1 >= 16 && age - 1 <= 35;
                }
                return age >= 16 && age <= 35;
            },
            gender: value => value !== '',
            idNumber: value => /^[0-9]{8,12}$/.test(value),
            email: value => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value),
            postalAddress: value => value.trim() !== '',
            postalCode: value => /^[0-9]{5}$/.test(value),
            subCounty: value => value.trim() !== '' && nameRegex.test(value),
            ward: value => value !== '',
            location: value => value.trim() !== '' && nameRegex.test(value),
            subLocation: value => value.trim() !== '' && nameRegex.test(value),
            village: value => value.trim() !== '' && nameRegex.test(value),
            pollingStation: value => value.trim() !== '' && nameRegex.test(value),
        };

        const errorMessages = {
            surname: 'Surname is required and must contain only letters, spaces or hyphens',
            firstName: 'First name is required and must contain only letters, spaces or hyphens',
            otherNames: 'Other names must contain only letters, spaces or hyphens',
            dob: 'Applicant must be between 16 and 35 years old',
            gender: 'Please select a gender',
            idNumber: 'Enter a valid ID number (8–12 digits)',
            email: 'Enter a valid email address',
            postalAddress: 'Postal address is required',
            postalCode: 'Postal code must be 5 digits',
            subCounty: 'Sub-county is required and must contain only letters, spaces or hyphens',
            ward: 'Please select a ward',
            location: 'Location is required and must contain only letters, spaces or hyphens',
            subLocation: 'Sub-location is required and must contain only letters, spaces or hyphens',
            village: 'Village is required and must contain only letters, spaces or hyphens',
            pollingStation: 'Polling station is required and must contain only letters, spaces or hyphens'
        };

        for (let field in validators) {
            const input = document.getElementById(field);
            if (input) {
                input.addEventListener('input', () => {
                    const value = input.value.trim();
                    const errorSpan = document.getElementById(`${field}-error`);
                    if (!validators[field](value)) {
                        errorSpan.textContent = errorMessages[field] || 'Invalid input';
                        input.style.borderColor = 'red';
                    } else {
                        errorSpan.textContent = '';
                        input.style.borderColor = 'green';
                    }
                });
            }
        }

        // Set allowed DOB range (between 16 and 35 years ago)
        const dob = document.getElementById('dob');
        if (dob) {
            const today = new Date();
            const minDate = new Date(today.getFullYear() - 35, today.getMonth(), today.getDate());
            const maxDate = new Date(today.getFullYear() - 16, today.getMonth(), today.getDate());

            dob.min = minDate.toISOString().split('T')[0];
            dob.max = maxDate.toISOString().split('T')[0];
        }
    });