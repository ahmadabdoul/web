 // Fetch the list of services and countries from their respective APIs or use the provided arrays
 const services = [
  { name: 'Amazon', logo:
  'images/amazon-logo.png.jpg' }, { name: 'Instagram', logo:
  'images/instagram-logo.png.png' }, { name: 'Facebook', logo:
  'images/facebook-logo.png.png' }, { name: 'WhatsApp', logo:
  'images/whatsapp-logo.png.png' }, { name: 'Telegram', logo:
  'images/telegram-logo.png' }, { name: 'Google', logo: 'images/google-logo.png'
  }, { name: 'OpenAI/ChatGPT', logo: 'images/openai-logo.png' }, { name: 'PayPal',
  logo: 'images/paypal-logo.png' }, { name: 'Fiverr', logo:
  'images/fiverr-logo.png' }, { name: 'Play Console', logo:
  'images/play-console-logo.png' }, { name: 'Skype', logo: 'images/skype-logo.png'
  }, { name: 'Snapchat', logo: 'images/snapchat-logo.png' }, { name: 'TikTok',
  logo: 'images/tiktok-logo.png' }, { name: 'Tinder', logo:
  'images/tinder-logo.png' }, { name: 'Twitter', logo: 'images/twitter-logo.png'
  }, { name: 'YouTube', logo: 'images/youtube-logo.png' }, { name: 'Yahoo', logo:
  'images/yahoo-logo.png' },
  // Add more services here...
];

// Function to fetch the list of countries using the restcountries API
function fetchCountries() {
  return fetch('https://restcountries.com/v3.1/all')
    .then(response => response.json())
    .then(data => {
      return data.map(country => ({
        name: country.name.common,
        flag: `flag-icon flag-icon-${country.cca2.toLowerCase()}`,
      }));
    });
}

function generateServiceItems() {
  // Generate service items dynamically
  const serviceItemsContainer = document.querySelector('.service-items');

  services.forEach(service => {
    const serviceItem = document.createElement('label');
    serviceItem.innerHTML = `
      <input type="radio" name="service" value="${service.name.toLowerCase()}" />
      <div class="service-item">
        <img src="${service.logo}" alt="${service.name}" />
        <span>${service.name}</span>
      </div>
    `;
    serviceItemsContainer.appendChild(serviceItem);
  });
}

function generateCountryItems(countries) {
  const countryItemsContainer = document.querySelector('.country-items');
  countries.forEach(country => {
    const countryItem = document.createElement('label');
    countryItem.innerHTML = `
      <input type="radio" name="country" value="${country.name.toLowerCase()}" />
      <div class="country-item">
        <span class="${country.flag}"></span>
        <span>${country.name}</span>
      </div>
    `;
    countryItemsContainer.appendChild(countryItem);
  });
}

function addSelectionRadioListeners() {
  // Add event listeners for service and country radios
  const serviceRadios = document.querySelectorAll('input[name="service"]');
  const countryRadios = document.querySelectorAll('input[name="country"]');
  const serviceItemsContainer = document.querySelector('.service-items');
  const countryItemsContainer = document.querySelector('.country-items');

  // Function to hide other services
  function hideOtherServices(selectedService) {
    serviceRadios.forEach(radio => {
      if (radio !== selectedService) {
        radio.parentNode.style.display = 'none';
      }
    });
    serviceItemsContainer.classList.add('hidden');
    countryItemsContainer.classList.remove('hidden');
  }

  // Function to hide other countries
  function hideOtherCountries(selectedCountry) {
    countryRadios.forEach(radio => {
      if (radio !== selectedCountry) {
        radio.parentNode.style.display = 'none';
      }
    });
    countryItemsContainer.classList.add('hidden');
    serviceItemsContainer.classList.remove('hidden');
  }

  serviceRadios.forEach(radio => {
    radio.addEventListener('change', () => {
      if (radio.checked) {
        hideOtherServices(radio);
      }
    });
  });

  countryRadios.forEach(radio => {
    radio.addEventListener('change', () => {
      if (radio.checked) {
        hideOtherCountries(radio);
      }
    });
  });
}

// ... (Previous code remains unchanged)

document.addEventListener('DOMContentLoaded', () => {
  const serviceSearchInput = document.getElementById('serviceSearch');
  const countrySearchInput = document.getElementById('countrySearch');

  const serviceRadios = document.querySelectorAll('input[name="service"]');
  const countryRadios = document.querySelectorAll('input[name="country"]');
  const serviceItemsContainer = document.querySelector('.service-items');
  const countryItemsContainer = document.querySelector('.country-items');

  serviceSearchInput.addEventListener('input', filterServices);
  countrySearchInput.addEventListener('input', filterCountries);

  fetchCountries()
    .then(countries => {
      generateCountryItems(countries);
      addSelectionRadioListeners();
    })
    .catch(error => console.error('Error fetching countries:', error));

  generateServiceItems();
});

function filterServices() {
  // Function to filter services based on the search input
  const searchTerm = serviceSearchInput.value.toLowerCase().trim();
  const serviceItems = document.querySelectorAll('.service-item');
  let isServiceAvailable = false;

  serviceItems.forEach(item => {
    const serviceName = item.querySelector('span').innerText.toLowerCase();
    if (serviceName.includes(searchTerm)) {
      item.style.display = 'block';
      isServiceAvailable = true;
    } else {
      item.style.display = 'none';
    }
  });

  if (!isServiceAvailable && searchTerm !== '') {
    alert('Service not available. Please contact us for more information.');
  }
}

function filterCountries() {
  // Function to filter countries based on the search input
  const searchTerm = countrySearchInput.value.toLowerCase().trim();
  const countryItems = document.querySelectorAll('.country-item');

  countryItems.forEach(item => {
    const countryName = item.querySelector('span:last-child').innerText.toLowerCase();
    if (countryName.includes(searchTerm)) {
      item.style.display = 'block';
    } else {
      item.style.display = 'none';
    }
  });
}




// Add JavaScript code to toggle FAQ answers
function toggleAccordion(id) {
  var panel = document.getElementById(id);
  panel.classList.toggle("active");
}


let navToggle = document.querySelector(".nav__toggle");
let navWrapper = document.querySelector(".nav__wrapper");

navToggle.addEventListener("click", function () {
  if (navWrapper.classList.contains("active")) {
    this.setAttribute("aria-expanded", "false");
    this.setAttribute("aria-label", "menu");
    navWrapper.classList.remove("active");
  } else {
    navWrapper.classList.add("active");
    this.setAttribute("aria-label", "close menu");
    this.setAttribute("aria-expanded", "true");
  }
});
