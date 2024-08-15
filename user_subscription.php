<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection
include 'db_connect.php';

// Include functions
include 'functions.php';

// Handle AJAX requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] == 'getAddons') {
            $productId = $_POST['productId'];
            $addons = getAddonsByProductId($productId);
            echo json_encode($addons);
            exit;
        }
        if ($_POST['action'] == 'getProducts') {
            $subscriptionPackageId = $_POST['subscriptionPackageId'];
            $products = getProductsBySubscriptionPackageId($subscriptionPackageId);
            echo json_encode($products);
            exit;
        }
    } else {
        $firstName = $_POST['customerFirstName'];
        $customerId = getCustomerById($firstName);
        $addressId = getCustomerAddressId($customerId);
        $subscriptionStartDate = $_POST['subscriptionStartDate'];
        $subscriptionType = getSubscriptionTypeNameById($_POST['subscriptionType']);

        $subscriptionEndDate = calculateSubscriptionEndDate($subscriptionStartDate, $subscriptionType);

        $response = array(
            'customerId' => $customerId,
            'addressId' => $addressId,
            'subscriptionPackageId' => $_POST['subscriptionPackage'],
            'productId' => $_POST['product'],
            'addonId' => $_POST['addon'],
            'subscriptionOptionId' => $_POST['subscriptionOption'],
            'deliverySlotId' => $_POST['deliverySlot'],
            'subscriptionTypeId' => $_POST['subscriptionType'],
            'subscriptionStartDate' => $subscriptionStartDate,
            'subscriptionEndDate' => $subscriptionEndDate
        );

        echo json_encode($response);
        exit;
    }
}

// Get subscription packages and other options
$packages = getSubscriptionPackages();
$deliveryslot = getDeliverySlot();
$subtype = getSubscriptionType();
$packages_option = getPackageOption();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Customer Subscription Details Form</title>
    <link rel="stylesheet" href="styles.css">
    <script src="script.js" defer></script>
</head>
<body>
    <div class="form-container">
        <h2>Customer Subscription Details Form</h2>
        <form method="post" onsubmit="submitForm(event)">
            <div class="form-group">
                <label for="customerFirstName">Customer First Name:</label>
                <input type="text" id="customerFirstName" name="customerFirstName" required>
            </div>

            <div class="form-group">
                <label for="subscriptionStartDate">Subscription Start Date:</label>
                <input type="date" id="subscriptionStartDate" name="subscriptionStartDate" required>
            </div>
            
            <div class="form-group">
                <label for="subscriptionPackage">Subscription Package:</label>
                <select name="subscriptionPackage" id="subscriptionPackage" required onchange="updateProductOptions(this.value)">
                    <option value="">Select a package</option>
                    <?php foreach ($packages as $package): ?>
                        <option value="<?php echo $package['subscription_package_id']; ?>">
                            <?php echo $package['subscription_package_name']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="product">Product:</label>
                <select name="product" id="product" required onchange="updateAddonOptions(this.value)">
                    <option value="">Select a product</option>
                </select>
            </div>

            <div class="form-group">
                <label for="addon">Add-on:</label>
                <select name="addon" id="addon" required>
                    <option value="">Select an add-on</option>
                </select>
            </div>

            <div class="form-group">
                <label for="subscriptionOption">Package Option:</label>
                <select name="subscriptionOption" id="subscriptionOption" required>
                    <?php foreach ($packages_option as $options): ?>
                        <option value="<?php echo $options['package_option_id']; ?>">
                            <?php echo $options['package_option_name']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="deliverySlot">Delivery Slot:</label>
                <select name="deliverySlot" id="deliverySlot" required>
                    <?php foreach ($deliveryslot as $slot): ?>
                        <option value="<?php echo $slot['delivery_slot_id']; ?>">
                            <?php echo $slot['delivery_slot_name']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="subscriptionType">Subscription Type:</label>
                <select name="subscriptionType" id="subscriptionType" required>
                    <?php foreach ($subtype as $typs): ?>
                        <option value="<?php echo $typs['subscription_type_id']; ?>">
                            <?php echo $typs['subscription_type_name']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <button type="submit">Submit</button>
            </div>
        </form>

        <div class="result"></div>
    </div>
</body>
</html>
