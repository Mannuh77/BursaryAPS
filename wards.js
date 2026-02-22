// wards.js - Polling stations data and functions for Kibwezi West Constituency

// Polling stations data for Kibwezi West
const pollingStationsData = {
    "Makindu": [
        "Ngomano Primary School", "Makutano Primary School", "Katulani Primary School",
        "Nzaikoni Primary School", "Ngaakaa Primary School", "Mbiuni Primary School",
        "Kalii Primary School", "Mitendeu Primary School", "Nthia Primary School",
        "Kangii Primary School", "Yimwaa Primary School", "Nduluni Primary School",
        "Masalani Primary School", "Ikungu Primary School", "Katheani D.e.b. Primary School",
        "Yindalani Primary School", "Musingini Primary School", "Kamboo Primary School",
        "Yingoso Primary School", "Kisingo Primary School", "Kisingo Youth Polytechnic",
        "Kai Primary School", "Syengoni Primary School", "Ngukuni Primary School",
        "Makindu A Primary School", "Ikoyo Primary School", "Mulilii Primary School",
        "Mbondeni Primary School", "Kimboo Primary School", "Mikululo Primary School",
        "Kiboko Primary School", "Mwailu Primary School", "Kanaani Primary School",
        "Kaasuvi Primary School", "Kiambani Primary School", "Yinzau Primary School",
        "Boma 4 Kari Public Grounds", "Kavete Dispensary", "Itulani Primary School"
    ],
    "Nguumo": [
        "Kilema Primary School", "Kilongoni Primary School", "Syumile Primary School",
        "Makusu Primary School", "Ndonguni Primary School", "Tunguni Primary School",
        "Wayona Primary School", "Muundani Primary School", "Yieni Primary School",
        "Kwa Mbae Primary School", "Mutantheeu Primary School", "'ngwiw''a Primary School'",
        "Sekeleni Primary School", "Nguumo Primary School", "Mukameni Primary School",
        "Ilatu Primary School", "Wiivia Primary School", "Uvileni Primary School",
        "Katangi Primary School", "Kyandulu Primary School", "Kawelu Primary School",
        "Kaunguni Primary School", "Ndeini Primary School", "Soto Primary School",
        "Kalakalya Primary School", "Wikiamba Primary School", "Isaani Primary School",
        "Yikisemei Primary School"
    ],
    "Kikumbulyu North": [
        "'king''utheni Primary School'", "Ngaikini Primary School", "Malembwa Primary School",
        "Mukononi Primary School", "Kathyaka Primary School", "Makaani Primary School",
        "Nyayo Primary School", "Kiaoni Primary School", "Kitulani Primary School",
        "Yikivala Primary School", "Kisayani Primary School", "Ithumula Primary School",
        "Kanyungu Primary School", "Mulangoni Primary School", "Milu Primary School",
        "Katilamuni Primary School", "Kiwanzani Primary School", "Nthongoni Primary School",
        "Ndetani Youth Polytechnic"
    ],
    "Kikumbulyu South": [
        "Ilingoni Primary School", "Kalungu Primary School", "Katulani Primary School",
        "Muatini Primary School", "Mikuyuni Primary School", "Kibwezi Township Primary School",
        "Mbui Nzau Primary School", "Ithambaume Primary School", "Kalulini Primary School",
        "Kwakyai Primary School", "Kevanda Primary School", "Masalani Primary School",
        "Kyanginywa Primary School", "Matinga Primary School", "Kie Grounds - Kibwezi Town"
    ],
    "Nguu/Masumba": [
        "Kikumini Primary School", "Ngongweni Primary School", "Ndunguni Primary School",
        "Itaava Primary School", "Ndulu Primary School", "Masumba Primary School",
        "Itulu Primary School", "Kakili Primary School", "Mwalili Primary School",
        "Mii Primary School", "Kitende Primary School", "Mukame A Mbeu Primary School",
        "Kwa Mukonyo Primary School", "Itiani Primary School", "Matutu Primary School",
        "Thithi Primary School", "Mweini Primary School", "Katulani Primary School",
        "Vololo Primary School", "Nguma Primary School", "Ndatani Primary School",
        "Kanyililya Primary School", "Utini Primary School", "Mbukani Primary School",
        "Uthasyo Primary School", "Muangeni Primary School", "Masamukye Primary School",
        "Kyeni Primary School", "Makasa Primary School", "Ngangani Primary School",
        "Mithumoni Primary School"
    ],
    "Emali/Mulala": [
        "Mwasangombe Primary School", "Ngelenge Primary School", "Kitandi Primary School",
        "Katisaa Primary School", "Uthangathi Primary School", "Mulala Hgm Primary School",
        "Matiku Primary School", "Kiuani Primary School", "Iviani Primary School",
        "Kiliku Primary School", "Kwa Kaleli Primary School", "Nduundune Primary School",
        "Emali Primary School", "Kwakakulu Primary School", "Tutini Primary School",
        "Kalima Primary School", "Ndwaani Primary School"
    ]
};

// Update polling stations based on ward selection
function updatePollingStations() {
    const wardSelect = document.getElementById('ward');
    const stationSelect = document.getElementById('pollingstation');
    const errorSpan = document.getElementById('pollingstationError');
    
    const selectedWard = wardSelect.value;
    
    // Clear previous stations and errors
    stationSelect.innerHTML = '';
    errorSpan.textContent = '';
    
    if (selectedWard === '') {
        stationSelect.disabled = true;
        stationSelect.innerHTML = '<option value="">-- Select Ward First --</option>';
        return;
    }
    
    // Enable and populate polling stations dropdown
    stationSelect.disabled = false;
    stationSelect.innerHTML = '<option value="">-- Select Polling Station --</option>';
    
    const stations = pollingStationsData[selectedWard] || [];
    
    // Add all stations for the selected ward
    stations.forEach(station => {
        const option = document.createElement('option');
        option.value = station;
        option.textContent = station;
        stationSelect.appendChild(option);
    });
}

// Form validation for registration
function validateRegistrationForm(event) {
    let isValid = true;
    
    // Clear all errors
    document.querySelectorAll('.error').forEach(span => span.textContent = '');
    
    // Validate ward selection
    const wardSelect = document.getElementById('ward');
    if (!wardSelect.value) {
        document.getElementById('wardError').textContent = 'Please select a ward';
        isValid = false;
    }
    
    // Validate polling station selection
    const stationSelect = document.getElementById('pollingstation');
    if (!stationSelect.value || stationSelect.disabled) {
        document.getElementById('pollingstationError').textContent = 'Please select a polling station';
        isValid = false;
    }
    
    // Validate password match
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm-password').value;
    
    if (password !== confirmPassword) {
        document.getElementById('confirmPasswordError').textContent = 'Passwords do not match';
        isValid = false;
    }
    
    // Validate password strength (optional)
    if (password.length < 6) {
        document.getElementById('passwordError').textContent = 'Password must be at least 6 characters';
        isValid = false;
    }
    
    // Validate email format
    const email = document.getElementById('email').value;
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        document.getElementById('emailError').textContent = 'Please enter a valid email address';
        isValid = false;
    }
    
    // Validate phone number (Kenyan format)
    const phone = document.getElementById('phone').value;
    const phoneRegex = /^(\+?254|0)[17]\d{8}$/;
    if (!phoneRegex.test(phone.replace(/\s+/g, ''))) {
        document.getElementById('phoneError').textContent = 'Please enter a valid Kenyan phone number (e.g., 0712345678)';
        isValid = false;
    }
    
    if (!isValid) {
        event.preventDefault(); // Prevent form submission
    }
}

// Initialize form on page load
function initializeForm() {
    const wardSelect = document.getElementById('ward');
    
    // Attach event listeners if elements exist
    if (wardSelect) {
        // Check for previously selected ward (for form re-display after validation errors)
        if (wardSelect.value) {
            updatePollingStations();
        }
        
        // Attach form submission validation
        const registrationForm = document.getElementById('registrationForm');
        if (registrationForm) {
            registrationForm.addEventListener('submit', validateRegistrationForm);
        }
    }
}

// Run initialization when DOM is fully loaded
document.addEventListener('DOMContentLoaded', function() {
    initializeForm();
});