<?php
include 'connect.php';

// Get innovation ID from URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch innovation details
$query = "SELECT * FROM innovation WHERE id = ?";
$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$innovation = mysqli_fetch_assoc($result); // CHANGED THIS LINE

// If no innovation found, redirect to all innovations
if (!$innovation) {
    header('Location: all-innovations.php');
    exit();
}

// Get 3 related innovations (same category, excluding current)
$relatedQuery = "SELECT id, startup_name, category, description FROM innovation WHERE category = ? AND id != ? ORDER BY RAND() LIMIT 3";
$relatedStmt = mysqli_prepare($con, $relatedQuery);
mysqli_stmt_bind_param($relatedStmt, 'si', $innovation['category'], $id);
mysqli_stmt_execute($relatedStmt);
$relatedResult = mysqli_stmt_get_result($relatedStmt);
$relatedInnovations = mysqli_fetch_all($relatedResult, MYSQLI_ASSOC);

// Category configurations
$categoryConfig = [
    'AgriTech' => [
        'color' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
        'gradient' => 'from-emerald-400 to-green-500',
        'icon' => 'fas fa-leaf'
    ],
    'FinTech' => [
        'color' => 'bg-indigo-100 text-indigo-800 border-indigo-200',
        'gradient' => 'from-indigo-400 to-blue-500',
        'icon' => 'fas fa-coins'
    ],
    'HealthTech' => [
        'color' => 'bg-rose-100 text-rose-800 border-rose-200',
        'gradient' => 'from-rose-400 to-pink-500',
        'icon' => 'fas fa-heartbeat'
    ],
    'EduTech' => [
        'color' => 'bg-violet-100 text-violet-800 border-violet-200',
        'gradient' => 'from-violet-400 to-purple-500',
        'icon' => 'fas fa-graduation-cap'
    ],
    'LogiTech' => [
        'color' => 'bg-amber-100 text-amber-800 border-amber-200',
        'gradient' => 'from-amber-400 to-orange-500',
        'icon' => 'fas fa-truck'
    ],
    'GreenTech' => [
        'color' => 'bg-teal-100 text-teal-800 border-teal-200',
        'gradient' => 'from-teal-400 to-emerald-500',
        'icon' => 'fas fa-sun'
    ],
    'MarketTech' => [
        'color' => 'bg-fuchsia-100 text-fuchsia-800 border-fuchsia-200',
        'gradient' => 'from-fuchsia-400 to-purple-500',
        'icon' => 'fas fa-store'
    ],
    'GovTech' => [
        'color' => 'bg-slate-100 text-slate-800 border-slate-200',
        'gradient' => 'from-slate-400 to-gray-500',
        'icon' => 'fas fa-landmark'
    ]
];

$config = $categoryConfig[$innovation['category']] ?? [
    'color' => 'bg-gray-100 text-gray-800 border-gray-200',
    'gradient' => 'from-gray-400 to-gray-500',
    'icon' => 'fas fa-lightbulb'
];

// Get previous and next innovation IDs for navigation
$prevQuery = "SELECT id FROM innovation WHERE id < ? ORDER BY id DESC LIMIT 1";
$prevStmt = mysqli_prepare($con, $prevQuery);
mysqli_stmt_bind_param($prevStmt, 'i', $id);
mysqli_stmt_execute($prevStmt);
$prevResult = mysqli_stmt_get_result($prevStmt);
$prevRow = mysqli_fetch_assoc($prevResult);
$prevId = $prevRow ? $prevRow['id'] : null; // ADDED THIS LINE

$nextQuery = "SELECT id FROM innovation WHERE id > ? ORDER BY id ASC LIMIT 1";
$nextStmt = mysqli_prepare($con, $nextQuery);
mysqli_stmt_bind_param($nextStmt, 'i', $id);
mysqli_stmt_execute($nextStmt);
$nextResult = mysqli_stmt_get_result($nextStmt);
$nextRow = mysqli_fetch_assoc($nextResult);
$nextId = $nextRow ? $nextRow['id'] : null; // ADDED THIS LINE
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Innovation Details - <?php echo htmlspecialchars($innovation['startup_name']); ?></title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <link rel="stylesheet" href="sources/css/style.css">


    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        .table-card {
            border-radius: 0.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            background-color: white;
            overflow: hidden;
        }

        .filter-section {
            background-color: #f8fafc;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-bottom: 1rem;
            border: 1px solid #e2e8f0;
        }

        .filter-select {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            background-color: white;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800">

    <!-- Header -->
    <?php include 'sections/header.php'; ?>


    <!-- Innovation Details Section -->
    <section class="min-h-screen py-8 bg-gray-50">
        <div class="container mx-auto px-4">
            <!-- Back Button -->
            <div class="mb-8">
                <a href="all-innovations.php"
                    class="inline-flex items-center text-primary hover:text-accent transition-colors duration-300">
                    <i class="fas fa-arrow-left mr-2"></i>
                    <span>Back to All Innovations</span>
                </a>
            </div>

            <!-- Main Content -->
            <div class="bg-white rounded-3xl shadow-xl overflow-hidden mb-12">
                <!-- Header with gradient -->
                <div class="h-4 bg-gradient-to-r <?php echo $config['gradient']; ?>"></div>

                <div class="p-8 md:p-12">
                    <!-- Header Section -->
                    <div class="flex flex-col md:flex-row md:items-start justify-between mb-8">
                        <div class="md:w-2/3">
                            <div class="flex items-center flex-wrap gap-2 mb-4">
                                <div
                                    class="w-16 h-16 rounded-2xl <?php echo str_replace('text-', 'bg-', explode(' ', $config['color'])[0]); ?> flex items-center justify-center shadow-lg mr-4">
                                    <i
                                        class="<?php echo $config['icon']; ?> <?php echo explode(' ', $config['color'])[1]; ?> text-2xl"></i>
                                </div>
                                <div>
                                    <span
                                        class="<?php echo $config['color']; ?> text-sm font-bold px-4 py-2 rounded-full border inline-block mb-2">
                                        <?php echo htmlspecialchars($innovation['category']); ?>
                                    </span>
                                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mt-2">
                                        <?php echo htmlspecialchars($innovation['startup_name']); ?>
                                    </h1>
                                </div>
                            </div>

                            <?php if (!empty($innovation['website_url'])): ?>
                                <div class="flex items-center mt-4">
                                    <a href="<?php echo htmlspecialchars($innovation['website_url']); ?>"
                                        target="_blank"
                                        class="inline-flex items-center px-6 py-3 bg-primary text-white font-semibold rounded-full hover:bg-primary/90 transition-colors duration-300 shadow-lg hover:shadow-xl">
                                        <i class="fas fa-external-link-alt mr-3"></i>
                                        <span>Visit Official Website</span>
                                    </a>
                                    <span class="ml-4 text-sm text-gray-500">
                                        <i class="fas fa-link mr-1"></i> External link
                                    </span>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- ID Badge -->
                        <div class="mt-4 md:mt-0">
                            <div class="bg-gray-100 rounded-xl p-4 inline-block">
                                <div class="text-sm text-gray-500">Innovation ID</div>
                                <div class="text-2xl font-bold text-primary">#<?php echo $innovation['id']; ?></div>
                            </div>
                        </div>
                    </div>

                    <!-- Description Section -->
                    <div class="mb-12">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                            <div
                                class="w-8 h-8 rounded-full <?php echo str_replace('text-', 'bg-', explode(' ', $config['color'])[0]); ?> flex items-center justify-center mr-3">
                                <i
                                    class="<?php echo $config['icon']; ?> <?php echo explode(' ', $config['color'])[1]; ?>"></i>
                            </div>
                            Solution Description
                        </h2>
                        <div
                            class="prose max-w-none text-gray-700 leading-relaxed text-lg border-l-4 <?php echo explode(' ', $config['color'])[2]; ?> pl-6 py-2">
                            <?php echo nl2br(htmlspecialchars($innovation['description'])); ?>
                        </div>
                    </div>

                    <!-- Details Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
                        <!-- Category Details -->
                        <div class="bg-gray-50 rounded-2xl p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-tag <?php echo explode(' ', $config['color'])[1]; ?> mr-3"></i>
                                Category Information
                            </h3>
                            <div class="space-y-3">
                                <div>
                                    <div class="text-sm text-gray-500">Primary Category</div>
                                    <div class="font-semibold text-gray-800">
                                        <?php echo htmlspecialchars($innovation['category']); ?></div>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-500">Innovation Type</div>
                                    <div class="font-semibold text-gray-800">Digital Platform</div>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-500">Status</div>
                                    <div class="font-semibold text-green-600 inline-flex items-center">
                                        <i class="fas fa-check-circle mr-2"></i>
                                        Active & Featured
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Links -->
                        <div class="bg-gray-50 rounded-2xl p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-link <?php echo explode(' ', $config['color'])[1]; ?> mr-3"></i>
                                Quick Actions
                            </h3>
                            <div class="space-y-3">
                                <?php if (!empty($innovation['website_url'])): ?>
                                    <a href="<?php echo htmlspecialchars($innovation['website_url']); ?>"
                                        target="_blank"
                                        class="flex items-center justify-between p-3 bg-white rounded-xl hover:shadow-md transition-shadow duration-300">
                                        <div class="flex items-center">
                                            <i class="fas fa-globe text-primary mr-3"></i>
                                            <span>Visit Website</span>
                                        </div>
                                        <i class="fas fa-arrow-right text-gray-400"></i>
                                    </a>
                                <?php endif; ?>

                                <button onclick="window.print()"
                                    class="w-full flex items-center justify-between p-3 bg-white rounded-xl hover:shadow-md transition-shadow duration-300">
                                    <div class="flex items-center">
                                        <i class="fas fa-print text-primary mr-3"></i>
                                        <span>Print Details</span>
                                    </div>
                                    <i class="fas fa-arrow-right text-gray-400"></i>
                                </button>

                                <button onclick="shareInnovation()"
                                    class="w-full flex items-center justify-between p-3 bg-white rounded-xl hover:shadow-md transition-shadow duration-300">
                                    <div class="flex items-center">
                                        <i class="fas fa-share-alt text-primary mr-3"></i>
                                        <span>Share Innovation</span>
                                    </div>
                                    <i class="fas fa-arrow-right text-gray-400"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 justify-between pt-8 border-t border-gray-200">
                        <?php if ($prevId): ?>
                            <a href="innovation-details.php?id=<?php echo $prevId; ?>"
                                class="flex items-center justify-center px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-full hover:bg-gray-200 transition-colors duration-300">
                                <i class="fas fa-arrow-left mr-3"></i>
                                <span>Previous Innovation</span>
                            </a>
                        <?php else: ?>
                            <div class="opacity-50">
                                <button disabled
                                    class="flex items-center justify-center px-6 py-3 bg-gray-100 text-gray-400 font-semibold rounded-full cursor-not-allowed">
                                    <i class="fas fa-arrow-left mr-3"></i>
                                    <span>Previous Innovation</span>
                                </button>
                            </div>
                        <?php endif; ?>

                        <a href="all-innovations.php"
                            class="flex items-center justify-center px-6 py-3 bg-primary text-white font-semibold rounded-full hover:bg-primary/90 transition-colors duration-300">
                            <i class="fas fa-th-large mr-3"></i>
                            <span>View All Innovations</span>
                        </a>

                        <?php if ($nextId): ?>
                            <a href="innovation-details.php?id=<?php echo $nextId; ?>"
                                class="flex items-center justify-center px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-full hover:bg-gray-200 transition-colors duration-300">
                                <span>Next Innovation</span>
                                <i class="fas fa-arrow-right ml-3"></i>
                            </a>
                        <?php else: ?>
                            <div class="opacity-50">
                                <button disabled
                                    class="flex items-center justify-center px-6 py-3 bg-gray-100 text-gray-400 font-semibold rounded-full cursor-not-allowed">
                                    <span>Next Innovation</span>
                                    <i class="fas fa-arrow-right ml-3"></i>
                                </button>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Related Innovations Section -->
            <?php if (!empty($relatedInnovations)): ?>
                <section id="related-innovations" class="mb-16">
                    <div class="flex items-center justify-between mb-8">
                        <h2 class="text-2xl font-bold text-gray-900">
                            Related Innovations in
                            <span
                                class="<?php echo explode(' ', $config['color'])[1]; ?>"><?php echo htmlspecialchars($innovation['category']); ?></span>
                        </h2>
                        <a href="all-innovations.php?category=<?php echo urlencode(strtolower($innovation['category'])); ?>"
                            class="text-primary hover:text-accent font-medium transition-colors duration-300">
                            View All <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <?php foreach ($relatedInnovations as $related):
                            $relatedConfig = $categoryConfig[$related['category']] ?? $config;
                            ?>
                            <a href="innovation-details.php?id=<?php echo $related['id']; ?>"
                                class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100">
                                <div class="h-2 bg-gradient-to-r <?php echo $relatedConfig['gradient']; ?>"></div>
                                <div class="p-6">
                                    <div class="flex items-center mb-4">
                                        <div
                                            class="w-12 h-12 rounded-xl <?php echo str_replace('text-', 'bg-', explode(' ', $relatedConfig['color'])[0]); ?> flex items-center justify-center mr-3">
                                            <i
                                                class="<?php echo $relatedConfig['icon']; ?> <?php echo explode(' ', $relatedConfig['color'])[1]; ?>"></i>
                                        </div>
                                        <span
                                            class="<?php echo $relatedConfig['color']; ?> text-xs font-bold px-3 py-1 rounded-full border">
                                            <?php echo htmlspecialchars($related['category']); ?>
                                        </span>
                                    </div>
                                    <h3
                                        class="text-lg font-bold text-gray-800 mb-3 group-hover:text-primary transition-colors duration-300">
                                        <?php echo htmlspecialchars(substr($related['startup_name'], 0, 40)) . (strlen($related['startup_name']) > 40 ? '...' : ''); ?>
                                    </h3>
                                    <p class="text-gray-600 text-sm line-clamp-2">
                                        <?php echo htmlspecialchars(substr($related['description'], 0, 100)) . (strlen($related['description']) > 100 ? '...' : ''); ?>
                                    </p>
                                    <div
                                        class="mt-4 pt-4 border-t border-gray-100 flex items-center text-primary font-medium text-sm">
                                        View Details
                                        <i
                                            class="fas fa-arrow-right ml-2 transform group-hover:translate-x-1 transition-transform duration-300"></i>
                                    </div>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endif; ?>

            <!-- Share Section -->
            <div class="gradient-light rounded-3xl p-8 text-center text-white">
                <h3 class="text-2xl font-bold mb-4">Share This Innovation</h3>
                <p class="mb-6 opacity-90">Help spread awareness about this innovative solution</p>
                <div class="flex justify-center space-x-4">
                    <button onclick="shareOnFacebook()"
                        class="w-12 h-12 bg-white text-blue-600 rounded-full flex items-center justify-center hover:scale-110 transition-transform duration-300">
                        <i class="fab fa-facebook-f text-xl"></i>
                    </button>
                    <button onclick="shareOnTwitter()"
                        class="w-12 h-12 bg-white text-blue-400 rounded-full flex items-center justify-center hover:scale-110 transition-transform duration-300">
                        <i class="fab fa-twitter text-xl"></i>
                    </button>
                    <button onclick="shareOnLinkedIn()"
                        class="w-12 h-12 bg-white text-blue-700 rounded-full flex items-center justify-center hover:scale-110 transition-transform duration-300">
                        <i class="fab fa-linkedin-in text-xl"></i>
                    </button>
                    <button onclick="shareViaEmail()"
                        class="w-12 h-12 bg-white text-gray-700 rounded-full flex items-center justify-center hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-envelope text-xl"></i>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php
    include 'sections/footer.php';
    include 'chatbot.php';

    if ($con) {
        mysqli_close($con);
    }
    ?>

    <script>
        function shareInnovation() {
            if (navigator.share) {
                navigator.share({
                    title: '<?php echo addslashes($innovation['startup_name']); ?>',
                    text: '<?php echo addslashes(substr($innovation['description'], 0, 100)); ?>...',
                    url: window.location.href
                });
            } else {
                // Fallback for browsers that don't support Web Share API
                navigator.clipboard.writeText(window.location.href).then(() => {
                    alert('Link copied to clipboard!');
                });
            }
        }

        function shareOnFacebook() {
            const url = encodeURIComponent(window.location.href);
            window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}`, '_blank');
        }

        function shareOnTwitter() {
            const text = encodeURIComponent('Check out this innovation: <?php echo addslashes($innovation['startup_name']); ?>');
            const url = encodeURIComponent(window.location.href);
            window.open(`https://twitter.com/intent/tweet?text=${text}&url=${url}`, '_blank');
        }

        function shareOnLinkedIn() {
            const url = encodeURIComponent(window.location.href);
            window.open(`https://www.linkedin.com/sharing/share-offsite/?url=${url}`, '_blank');
        }

        function shareViaEmail() {
            const subject = encodeURIComponent('Innovation: <?php echo addslashes($innovation['startup_name']); ?>');
            const body = encodeURIComponent(`Check out this innovation:\n\n${window.location.href}\n\n<?php echo addslashes(substr($innovation['description'], 0, 150)); ?>...`);
            window.location.href = `mailto:?subject=${subject}&body=${body}`;
        }
    </script>

    <style>
        .prose {
            line-height: 1.8;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Smooth transitions */
        a,
        button {
            transition: all 0.3s ease;
        }

        /* Print styles */
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>

    <!-- scripts -->
    <script src="sources/scripts/script.js"></script>
</body>

</html>