document.addEventListener('DOMContentLoaded', function() {
    const cryptoTable = document.getElementById('cryptoTable').querySelector('tbody');

   
        let Dat = document.getElementById('myParagraph');
       let cryptos = [
        { number: 1, coin: 'Bitcoin', rate: 1.2, price: 70744.33, quantity: 0, value: 0 },
        { number: 2, coin: 'Ethereum', rate: -0.9, price: 3744.33, quantity: 0, value: 0 },
        { number: 3, coin: 'BigG', rate: 6.9, price: 10.69 , quantity: 0, value: 0 },
        { number: 4, coin: 'BNB', rate: 6.9, price: 134.69 , quantity: 0, value: 0 },
        { number: 5, coin: 'Solana', rate: 6.9, price: 434.69 , quantity: 0, value: 0 },
        { number: 6, coin: 'Dogcoin', rate: 6.9, price: 13.69 , quantity: 0, value: 0 },
        { number: 7, coin: 'Cardano', rate: -6.9, price: 0.55 , quantity: 0, value: 0 },
        { number: 8, coin: 'Ripple', rate: 6.9, price: 77 , quantity: 0, value: 4585 },
        { number: 9, coin: 'Polkadot', rate: 9.9, price: 800, quantity: 0, value: 777 },
        { number: 10, coin: 'Chainlink', rate: 2.9, price: 4 , quantity: 0, value: 7477 },
        { number: 11, coin: 'Binance', rate: 3.9, price: 550, quantity: 0, value: 55 },
        { number: 12, coin: 'Litecoin', rate: -1.9, price: 0.77 , quantity: 0, value: 0 },
        { number: 13, coin: 'Stellar', rate: 6.2, price: 0.2 , quantity: 0, value: 0},
        { number: 14, coin: 'Cosmos', rate: 5.9, price: 0.55 , quantity: 0, value: 12 },
        { number: 15, coin: 'Monero', rate: -2.9, price: 77, quantity: 0, value: 0 },
        { number: 16, coin: 'Zcash', rate: 1.9, price: 330 , quantity: 0, value: 22},
        { number: 17, coin: 'Ave', rate: 0.9, price: 0.5, quantity: 0, value: 12 }
    ];
    Dat.innerHTML.trim();
    console.log(Dat.innerHTML.split(","));
    let tabpar=Dat.innerHTML.split(",")
    console.log(tabpar);
    let tab=[];

    for (let i = 0; i < tabpar.length; i++) {
        let ta = tabpar[i].split("#");
        tab[ta[0]] = ta[1];
    }
    
   console.log(tab);
   cryptos.forEach(crypto => {
    crypto.quantity=tab[crypto.coin];
    
   });
 
    
    let totaleMoney = 0 ;

    let realMoney = parseFloat(tab["Money"]) ;

    function updateRealMoney(data) {
        document.getElementById('RealMoney').innerText = `${data.toFixed(2)} $`;
    };

    updateRealMoney(realMoney);


    // Function to populate or update the table with data
    function populateTable(data,inf) {
        cryptoTable.innerHTML = ''; // Clear the table before repopulating
        let totalValue = 0; // Initialize total value for each population
        let i=0;
        data.forEach(crypto => {
            
            if(crypto.quantity > 0.0){
                i=i+1;
            let row = cryptoTable.insertRow();
            
            // Determine the class for the rate based on whether it's positive or negative
            let rateClass = parseFloat(crypto.rate) >= 0 ? 'positive' : 'negative';
            
            let cryptoValue = parseFloat(crypto.quantity*crypto.price); // Parse the value as float to ensure accurate addition
            totalValue += cryptoValue;

            row.innerHTML = `
                <td>${i}</td>
                <td>${crypto.coin}</td>
                <td class="${rateClass}">${crypto.rate} %</td>
                <td>${crypto.price} $</td>
                <td>${crypto.quantity}</td>
                <td>${cryptoValue.toFixed(2)} $</td>
            `;}
        });
        
        document.getElementById('cryptoTotal').innerText = `${totalValue.toFixed(2)} $`;
        document.getElementById('TotalMoney').innerText = `${(totalValue+inf).toFixed(2)} $`;
    }

    // Initially populate the table
    populateTable(cryptos,realMoney);

    // Function to update rates and prices randomly
    function updateRates() {
        var totalValue = 0; // Reset total value at each update

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
        document.getElementById('cryptoTotal').innerText = `${totalValue.toFixed(2)} $`;
        console.log($totalValue)
        document.getElementById('TotalMoney').innerText = `${(totalValue+realMoney).toFixed(2)} $`;
        
        
    }

    // Set the interval for updating rates
    const T = 1000; // Time in milliseconds (e.g., 5000ms = 5 seconds)
    setInterval(updateRates, T);
});


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
