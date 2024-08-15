function validateForm() {
    var firstName = document.getElementById("customerFirstName").value;
    if (firstName === "") {
        alert("Customer First Name must be filled out");
        return false;
    }
    return true;
}

function submitForm(event) {
    event.preventDefault();
    if (!validateForm()) {
        return;
    }

    var formData = new FormData(document.querySelector('form'));
    formData.append('ajax', 1);

    fetch('', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        document.querySelector('.result').innerHTML = `
            <p>Customer ID: ${data.customerId}</p>
            <p>Customer Address ID: ${data.addressId}</p>
            <p>Selected Subscription Package ID: ${data.subscriptionPackageId}</p>
            <p>Selected Product ID: ${data.productId}</p>
            <p>Selected Add-on ID: ${data.addonId}</p>
            <p>Selected Package Option ID: ${data.subscriptionOptionId}</p>
            <p>Selected Delivery Slot ID: ${data.deliverySlotId}</p>
            <p>Selected Subscription Type ID: ${data.subscriptionTypeId}</p>
            <p>Subscription Start Date: ${data.subscriptionStartDate}</p>
            <p>Subscription End Date: ${data.subscriptionEndDate}</p>
        `;
    })
    .catch(error => console.error('Error:', error));
}

function updateProductOptions(subscriptionPackageId) {
    var formData = new FormData();
    formData.append('action', 'getProducts');
    formData.append('subscriptionPackageId', subscriptionPackageId);

    fetch('', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(products => {
        var productSelect = document.getElementById('product');
        productSelect.innerHTML = '<option value="">Select a product</option>';
        products.forEach(product => {
            var option = document.createElement('option');
            option.value = product.product_id;
            option.textContent = product.product_name;
            productSelect.appendChild(option);
        });
    })
    .catch(error => console.error('Error:', error));
}

function updateAddonOptions(productId) {
    var formData = new FormData();
    formData.append('action', 'getAddons');
    formData.append('productId', productId);

    fetch('', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(addons => {
        var addonSelect = document.getElementById('addon');
        addonSelect.innerHTML = '<option value="">Select an add-on</option>';
        addons.forEach(addon => {
            var option = document.createElement('option');
            option.value = addon.addon_id;
            option.textContent = addon.addon_name;
            addonSelect.appendChild(option);
        });
    })
    .catch(error => console.error('Error:', error));
}
