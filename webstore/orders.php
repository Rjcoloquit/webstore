<?php
require_once 'includes/functions.php';
require_once 'includes/connection.php';

// Redirect if not logged in
if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];
$user = getUserById($userId);

// Get all orders for the user
$orders = getUserOrders($userId);

include 'includes/header.php';
?>

<section class="dashboard-section py-5">
    <div class="container">
        <div class="dashboard-header mb-4">
            <h1 class="display-6 fw-bold mb-1">My Orders</h1>
            <p class="text-muted">View your order history and track current orders.</p>
        </div>
        <div class="row g-4">
            <!-- Sidebar Navigation -->
            <div class="col-lg-3">
                <div class="card shadow-sm rounded-4 border-0 mb-4 mb-lg-0">
                    <div class="card-body p-4">
                        <div class="user-profile text-center mb-4">
                            <div class="profile-image mb-2 mx-auto" style="width: 80px; height: 80px;">
                                <img src="images/default-profile.jpg" alt="Profile Image" class="rounded-circle w-100 h-100 object-fit-cover">
                            </div>
                            <div class="profile-info">
                                <h5 class="fw-semibold mb-0"><?= htmlspecialchars($user['full_name']) ?></h5>
                                <p class="text-muted small mb-0"><?= htmlspecialchars($user['email']) ?></p>
                            </div>
                        </div>
                        <nav class="dashboard-nav">
                            <ul class="nav flex-column gap-2">
                                <li class="nav-item"><a class="nav-link rounded-pill" href="dashboard.php"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a></li>
                                <li class="nav-item"><a class="nav-link rounded-pill active" href="orders.php"><i class="fas fa-shopping-bag me-2"></i> My Orders</a></li>
                                <li class="nav-item"><a class="nav-link rounded-pill" href="account-settings.php"><i class="fas fa-user-cog me-2"></i> Account Settings</a></li>
                                <li class="nav-item"><a class="nav-link rounded-pill" href="wishlist.php"><i class="fas fa-heart me-2"></i> Wishlist</a></li>
                                <li class="nav-item"><a class="nav-link rounded-pill" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
            <!-- Main Content -->
            <div class="col-lg-9">
                <div class="card shadow-sm border-0 rounded-4 mb-4">
                    <div class="card-body">
                        <h2 class="h5 fw-bold mb-3">Order History</h2>
                        <?php if (empty($orders)): ?>
                            <div class="text-center py-5">
                                <div class="mb-3"><i class="fas fa-shopping-bag fa-3x text-muted"></i></div>
                                <h2 class="fw-semibold mb-2">No Orders Yet</h2>
                                <p class="text-muted mb-3">You haven't placed any orders yet. Start shopping to see your orders here.</p>
                                <a href="shop.php" class="btn btn-primary">Start Shopping</a>
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th>Order #</th>
                                            <th>Date</th>
                                            <th>Items</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($orders as $order): ?>
                                            <tr>
                                                <td>#<?= $order['order_id'] ?></td>
                                                <td><?= date('M j, Y', strtotime($order['order_date'])) ?></td>
                                                <td><?= countOrderItems($order['order_id']) ?></td>
                                                <td>₱<?= number_format($order['total_amount'], 2) ?></td>
                                                <td>
                                                    <span class="badge bg-<?= getStatusColor($order['status']) ?>">
                                                        <?= ucfirst($order['status']) ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="order-details.php?id=<?= $order['order_id'] ?>" class="btn btn-sm btn-outline-secondary">View Details</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.dashboard-section {
    background-color: var(--light-bg, #f8f9fa);
}
.dashboard-header h1 {
    font-size: 2rem;
}
.dashboard-nav .nav-link {
    color: #333;
    font-weight: 500;
    padding: 0.75rem 1.25rem;
    transition: background 0.2s, color 0.2s;
}
.dashboard-nav .nav-link.active, .dashboard-nav .nav-link:hover {
    background: #e3f2fd;
    color: #1976d2;
}
.card {
    border-radius: 1rem;
}
.badge.bg-warning { background-color: #ffc107 !important; color: #fff; }
.badge.bg-info { background-color: #0dcaf0 !important; color: #fff; }
.badge.bg-primary { background-color: #0d6efd !important; color: #fff; }
.badge.bg-success { background-color: #198754 !important; color: #fff; }
.badge.bg-danger { background-color: #dc3545 !important; color: #fff; }
</style>

<?php include 'includes/footer.php'; ?>