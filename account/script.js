function toggleSidebar() {
  var sidebar = document.getElementById("sidebar");
  sidebar.style.left = sidebar.style.left === "-250px" ? "0" : "-250px";
}




const services = [
  { name: 'Amazon', logo: 'images/amazon-logo.png.jpg' },
  { name: 'Instagram', logo: 'images/instagram-logo.png.png' },
  { name: 'Facebook', logo: 'images/facebook-logo.png.png' },
  { name: 'WhatsApp', logo: 'images/whatsapp-logo.png.png' },
  { name: 'Telegram', logo: 'images/telegram-logo.png' },
  { name: 'Google', logo: 'images/google-logo.png' },
  { name: 'OpenAI/ChatGPT', logo: 'images/openai-logo.png' }
];

const countries = [
  { name: 'USA', flag: 'usa' },
  { name: 'UK', flag: 'uk' },
  { name: 'Germany', flag: 'germany' },
  { name: 'France', flag: 'france' },
  { name: 'England', flag: 'england' },
  { name: 'Romania', flag: 'romania' },
  { name: 'Russia', flag: 'russia' },
  { name: 'Vietnam', flag: 'vietnam' }
];

const serviceItemsContainer = document.querySelector('.service-items');
const countryItemsContainer = document.querySelector('.country-items');
const serviceRadios = document.querySelectorAll('input[name="service"]');
const countryRadios = document.querySelectorAll('input[name="country"]');

// // Generate service items dynamically
// services.forEach(service => {
//   const serviceItem = document.createElement('label');
//   serviceItem.innerHTML = `
//     <input type="radio" name="service" value="${service.name.toLowerCase()}" />
//     <div class="service-item">
//       <img src="${service.logo}" alt="${service.name}" />
//       <span>${service.name}</span>
//     </div>
//   `;
//   serviceItemsContainer.appendChild(serviceItem);
// });

// Generate country items dynamically
// countries.forEach(country => {
//   const countryItem = document.createElement('label');
//   countryItem.innerHTML = `
//     <input type="radio" name="country" value="${country.name.toLowerCase()}" />
//     <div class="country-item">
//       <img src="flags/${country.flag}-flag.png" alt="${country.name}" />
//       <span>${country.name}</span>
//     </div>
//   `;
//   countryItemsContainer.appendChild(countryItem);
// });

// Event listeners for service radios
serviceRadios.forEach(radio => {
  radio.addEventListener('change', () => {
    if (radio.checked) {
      serviceRadios.forEach(otherRadio => {
        if (otherRadio !== radio) {
          otherRadio.parentNode.style.display = 'none';
        }
      });
      serviceItemsContainer.classList.add('hidden');
      countryItemsContainer.classList.remove('hidden');
    }
  });
});

// Event listeners for country radios
countryRadios.forEach(radio => {
  radio.addEventListener('change', () => {
    if (radio.checked) {
      countryRadios.forEach(otherRadio => {
        if (otherRadio !== radio) {
          otherRadio.parentNode.style.display = 'none';
        }
      });
      countryItemsContainer.classList.add('hidden');
      serviceItemsContainer.classList.remove('hidden');
    }
  });
});

