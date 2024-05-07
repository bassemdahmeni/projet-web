function initializeSliders() {
    const sliderContainers = document.querySelectorAll('.slider-container');

    sliderContainers.forEach(container => {
        let currentIndex = 0; // Initialize index for each container

        // Function to slide to the next div within this container
        function slideToNextDiv() {
            const divs = container.querySelectorAll('.Container');
            const divWidth = divs[0].offsetWidth;
            currentIndex++; // Increment to the next div

            // Calculate the new scroll position
            let newScrollPosition = currentIndex * divWidth;

            // Check if we've reached the end of the divs
            if (currentIndex >= divs.length) {
                currentIndex = 0; // Reset to first div
                newScrollPosition = 0; // Reset scroll position
            }

            // Smoothly scroll to the new div
            container.scrollTo({
                left: newScrollPosition,
                behavior: 'smooth'
            });
        }

        // Automatically slide to the next div every 3 seconds
        setInterval(slideToNextDiv, 3000);
    });
}

// Call the function on page load or when appropriate
initializeSliders();













const cryptoTable = document.getElementById('cryptoTable').querySelector('tbody');

// Example data
let cryptos = [
    { number: 1, coin: 'Bitcoin', rate: 1.2, price: 70744.33, quantity: 1.23, value: 87015.53 },
    { number: 2, coin: 'Ethereum', rate: -0.9, price: 3744.33, quantity: 10.09, value: 37780.29 },
    { number: 3, coin: 'Big G', rate: 6.9, price: 0.69 , quantity: 420.69, value: 0 },
    { number: 4, coin: 'BNB', rate: 6.9, price: 0.69 , quantity: 420.69, value: 0 },
    { number: 5, coin: 'Solana', rate: 6.9, price: 0.69 , quantity: 80.69, value: 0 },
    { number: 6, coin: 'Dogcoin', rate: 6.9, price: 0.69 , quantity: 266.69, value: 0 },
    { number: 7, coin: 'Cardano', rate: 6.9, price: 0.55 , quantity: 223.69, value: 0 },
    { number: 8, coin: 'Ripple', rate: 6.9, price: 77 , quantity: 2255.69, value: 4585 },
    { number: 9, coin: 'Polkadot', rate: 9.9, price: 800, quantity: 22869, value: 777 },
    { number: 10, coin: 'Chainlink', rate: 2.9, price: 4 , quantity: 227.69, value: 7477 },
    { number: 11, coin: 'Binance', rate: 3.9, price: 550, quantity: 227.69, value: 55 },
    { number: 12, coin: 'Litecoin', rate: 1.9, price: 0.77 , quantity: 22.69, value: 0 },
    { number: 13, coin: 'Stellar', rate: 6.2, price: 0.2 , quantity: 221.69, value: 0},
    { number: 14, coin: 'Cosmos', rate: 5.9, price: 0.55 , quantity: 22.69, value: 12 },
    { number: 15, coin: 'Monero', rate: 2.9, price: 77, quantity: 22.269, value: 0 },
    { number: 16, coin: 'Zcash', rate: 1.9, price: 330 , quantity: 225.69, value: 22},
    { number: 17, coin: 'Ave', rate: 0.9, price: 0.5, quantity: 22.69, value: 12 },
    
    // ...more cryptocurrencies
];

let totaleMoney = 0 ;

let realMoney = 1000.69 ;




// Define a variable to store the current filter
let currentFilter = '';

// Function to populate or update the table with data
function populateTable(data, inf) {
    cryptoTable.innerHTML = ''; // Clear the table before repopulating
    let totalValue = 0; // Initialize total value for each population

    data
        .filter(crypto => crypto.coin.toLowerCase().includes(currentFilter.toLowerCase())) // Filter based on current filter
        .forEach(crypto => {
            let row = cryptoTable.insertRow();

            // Determine the class for the rate based on whether it's positive or negative
            let rateClass = parseFloat(crypto.rate) >= 0 ? 'positive' : 'negative';
            
            let cryptoValue = parseFloat(crypto.value); // Parse the value as float to ensure accurate addition
            totalValue += cryptoValue;

            row.innerHTML = `
                <td>${crypto.number}</td>
                <td>${crypto.coin}</td>
                <td class="${rateClass}">${crypto.rate} %</td>
                <td>${crypto.price} $</td>
                <td>${crypto.quantity}</td>
                <td>${cryptoValue.toFixed(2)} $</td>
            `;
        });
}

// Get the input element and add event listener
const searchInput = document.querySelector('.input33');
searchInput.addEventListener('keyup', function() {
    // Update the current filter each time the user types
    currentFilter = searchInput.value;
    // Repopulate the table using the updated filter
    populateTable(cryptos, realMoney);
});

// Initially populate the table without any filter
populateTable(cryptos, realMoney);

// Update the table with new data and reapply the filter
function updateRates() {
    // Perform the regular updates as before
    // After updating cryptos with new rates, prices, etc.
    populateTable(cryptos, realMoney);
}



// Function to update rates and prices randomly
function updateRates() {
    let totalValue = 0; // Reset total value at each update

    cryptos = cryptos.map(crypto => {
        // Generates a new rate between -10 and 10
        const newRate = (Math.random() * 20 - 10).toFixed(1);
        
        // Calculate the new price based on the rate change
        const priceChangePercentage = parseFloat(newRate) / 100;
        const newPrice = parseFloat(crypto.price) * (1 + priceChangePercentage); // Ensure we parse the price as float
        
        // Calculate the new value based on the new price
        const newValue = parseFloat(crypto.quantity) * newPrice;

        // Accumulate total value
        totalValue += newValue;

        // Return the updated crypto object with the new rate, new price, and new value
        return {
            ...crypto,
            rate: newRate,
            price: newPrice.toFixed(2),
            value: newValue.toFixed(2),
        };
    });

    // Update the table with new cryptocurrency data
    populateTable(cryptos ,realMoney);

    // Update the total crypto money display with the accumulated value
    // document.getElementById('cryptoTotal').innerText = `${totalValue.toFixed(2)} $`;
    // document.getElementById('TotalMoney').innerText = `${(totalValue+realMoney).toFixed(2)} $`;
}

// Set the interval for updating rates
const T = 1000; // Time in milliseconds (e.g., 5000ms = 5 seconds)
setInterval(updateRates, T);


