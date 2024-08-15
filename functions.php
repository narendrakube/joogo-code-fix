<?php
// Function to get customer ID by first name
function getCustomerById($firstName) {
    global $conn;
    $sql = "SELECT customer_id FROM customer WHERE customer_first_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $firstName);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();
    return $row['customer_id'];
}

// Function to get customer address ID by customer ID
function getCustomerAddressId($customerId) {
    global $conn;
    $sql = "SELECT customer_address_id FROM customer_address WHERE customer_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $customerId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();
    return $row['customer_address_id'];
}

// Function to get subscription packages
function getSubscriptionPackages() {
    global $conn;
    $sql = "SELECT subscription_package_id, subscription_package_name FROM subscription_package";
    $result = $conn->query($sql);
    $packages = array();
    while ($row = $result->fetch_assoc()) {
        $packages[] = $row;
    }
    return $packages;
}

// Function to get package options
function getPackageOption() {
    global $conn;
    $sql = "SELECT package_option_id, package_option_name FROM package_option";
    $result = $conn->query($sql);
    $packages_option = array();
    while ($row = $result->fetch_assoc()) {
        $packages_option[] = $row;
    }
    return $packages_option;
}

// Function to get delivery slots
function getDeliverySlot() {
    global $conn;
    $sql = "SELECT delivery_slot_id, delivery_slot_name FROM delivery_slot";
    $result = $conn->query($sql);
    $deliveryslot = array();
    while ($row = $result->fetch_assoc()) {
        $deliveryslot[] = $row;
    }
    return $deliveryslot;
}

// Function to get subscription types
function getSubscriptionType() {
    global $conn;
    $sql = "SELECT subscription_type_id, subscription_type_name FROM subscription_type";
    $result = $conn->query($sql);
    $subtype = array();
    while ($row = $result->fetch_assoc()) {
        $subtype[] = $row;
    }
    return $subtype;
}

// Function to get products based on subscription package
function getProductsBySubscriptionPackageId($subscriptionPackageId) {
    global $conn;
    $sql = "SELECT product_id, product_name FROM joogo.vw_subscription_package_details WHERE subscription_package_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $subscriptionPackageId);
    $stmt->execute();
    $result = $stmt->get_result();
    $products = array();
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
    $stmt->close();
    return $products;
}

// Function to get add-ons based on product ID
function getAddonsByProductId($productId) {
    global $conn;
    $sql = "SELECT addon_id, addon_name FROM joogo.vw_product_addon_details WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    $addons = array();
    while ($row = $result->fetch_assoc()) {
        $addons[] = $row;
    }
    $stmt->close();
    return $addons;
}

// Function to get subscription type name by ID
function getSubscriptionTypeNameById($subscriptionTypeId) {
    global $conn;
    $sql = "SELECT subscription_type_name FROM subscription_type WHERE subscription_type_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $subscriptionTypeId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();
    return $row['subscription_type_name'];
}

/*
// Function to calculate subscription end date
function calculateSubscriptionEndDate($startDate, $subscriptionType) {
    $endDate = new DateTime($startDate);

    switch (strtolower($subscriptionType)) {
        case 'monthly':
            $endDate->modify('+1 month');
            break;
        case 'weekly':
            $endDate->modify('+1 week');
            break;
        case 'half-monthly':
            $endDate->modify('+15 days');
            break;
    }

    return $endDate->format('Y-m-d');
}
*/
// Function to calculate subscription end date
function calculateSubscriptionEndDate($startDate, $subscriptionType) {
    $endDate = new DateTime($startDate);

    switch (strtolower($subscriptionType)) {
        case 'monthly':
            $endDate->modify('+1 month');
            break;
        case 'weekly':
            $endDate->modify('+1 week');
            break;
        case 'half-monthly':
            $endDate->modify('+15 days');
            break;
        default:
            throw new Exception("Invalid subscription type");
    }

    return $endDate->format('Y-m-d');
}

?>
