<?php
include 'connect.php';

// Get category filter if provided
$categoryFilter = isset($_GET['category']) ? strtolower($_GET['category']) : '';
$whereClause = '';
$params = [];
$types = '';

if ($categoryFilter) {
    $whereClause = "WHERE LOWER(category) = ?";
    $params[] = $categoryFilter;
    $types .= 's';
}

// Get all innovations with optional filter
$query = "SELECT id, startup_name, description, website_url, category FROM innovation $whereClause ORDER BY category, startup_name";
$stmt = mysqli_prepare($con, $query);

if ($categoryFilter) {
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$innovations = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Get unique categories for filter
$catQuery = "SELECT DISTINCT category FROM innovation ORDER BY category";
$catResult = mysqli_query($con, $catQuery);
$categories = mysqli_fetch_all($catResult, MYSQLI_ASSOC);

// Get counts per category
$countQuery = "SELECT category, COUNT(*) as count FROM innovation GROUP BY category ORDER BY category";
$countResult = mysqli_query($con, $countQuery);
$categoryCounts = [];
while($row = mysqli_fetch_assoc($countResult)) {
    $categoryCounts[$row['category']] = $row['count'];
}

// Category configurations
$categoryConfig = [
    'AgriTech' => [
        'bg' => 'bg-emerald-100',
        'text' => 'text-emerald-800',
        'border' => 'border-emerald-200',
        'gradient' => 'from-emerald-400 to-green-500',
        'icon' => 'fas fa-leaf',
        'iconBg' => 'bg-emerald-50'
    ],
    'FinTech' => [
        'bg' => 'bg-indigo-100',
        'text' => 'text-indigo-800',
        'border' => 'border-indigo-200',
        'gradient' => 'from-indigo-400 to-blue-500',
        'icon' => 'fas fa-coins',
        'iconBg' => 'bg-indigo-50'
    ],
    'HealthTech' => [
        'bg' => 'bg-rose-100',
        'text' => 'text-rose-800',
        'border' => 'border-rose-200',
        'gradient' => 'from-rose-400 to-pink-500',
        'icon' => 'fas fa-heartbeat',
        'iconBg' => 'bg-rose-50'
    ],
    'EduTech' => [
        'bg' => 'bg-violet-100',
        'text' => 'text-violet-800',
        'border' => 'border-violet-200',
        'gradient' => 'from-violet-400 to-purple-500',
        'icon' => 'fas fa-graduation-cap',
        'iconBg' => 'bg-violet-50'
    ],
    'LogiTech' => [
        'bg' => 'bg-amber-100',
        'text' => 'text-amber-800',
        'border' => 'border-amber-200',
        'gradient' => 'from-amber-400 to-orange-500',
        'icon' => 'fas fa-truck',
        'iconBg' => 'bg-amber-50'
    ],
    'GreenTech' => [
        'bg' => 'bg-teal-100',
        'text' => 'text-teal-800',
        'border' => 'border-teal-200',
        'gradient' => 'from-teal-400 to-emerald-500',
        'icon' => 'fas fa-sun',
        'iconBg' => 'bg-teal-50'
    ],
    'MarketTech' => [
        'bg' => 'bg-fuchsia-100',
        'text' => 'text-fuchsia-800',
        'border' => 'border-fuchsia-200',
        'gradient' => 'from-fuchsia-400 to-purple-500',
        'icon' => 'fas fa-store',
        'iconBg' => 'bg-fuchsia-50'
    ],
    'GovTech' => [
        'bg' => 'bg-slate-100',
        'text' => 'text-slate-800',
        'border' => 'border-slate-200',
        'gradient' => 'from-slate-400 to-gray-500',
        'icon' => 'fas fa-landmark',
        'iconBg' => 'bg-slate-50'
    ]
];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>innovation Hubs - Huduma WhiteBox</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables CSS & JS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

    <!-- Include DataTables CSS -->
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css"> -->
    <link rel="stylesheet" href="sources/css/style.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <link rel="stylesheet" href="sources/css/style.css">

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

    <!-- Hubs Hero Section -->
    <section class="about-hero py-16 text-white">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-6">All Innovations<</h1>
            <p class="text-lg text-white-600 max-w-3xl mx-auto">
                        Browse through our complete collection of <?php echo count($innovations); ?> innovative
                        solutions
                        <?php if ($categoryFilter): ?>
                            in <span class="font-semibold text-primary"><?php echo ucfirst($categoryFilter); ?></span>
                        <?php endif; ?>
                    </p>
        </div>
    </section>

    <!-- Contact Information Section -->
    <section class="py-12 bg-gray-1000">
        <section id="all-innovations" class="min-h-screen py-8">
            <div class="container mx-auto px-4">
                <!-- Header -->
                <div class="text-center mb-12">
                    <!-- <h1 class="text-4xl font-bold text-primary mb-4">All Innovations</h1>
                    <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                        Browse through our complete collection of < ?php echo count($innovations); ?> innovative
                        solutions
                        < ?php if ($categoryFilter): ?>
                            in <span class="font-semibold text-primary"><?php echo ucfirst($categoryFilter); ?></span>
                        < ?php endif; ?>
                    </p> -->

                    <!-- Back to home -->
                    <div class="mt-6">
                        <a href="index.php#innovations"
                            class="inline-flex items-center text-primary hover:text-accent transition-colors duration-300">
                            <i class="fas fa-arrow-left mr-2"></i>
                            <span>Back to Home</span>
                        </a>
                    </div>
                </div>

                <!-- Stats and Search -->
                <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-primary mb-2"><?php echo count($innovations); ?></div>
                            <p class="text-gray-600">Total Innovations</p>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-accent mb-2"><?php echo count($categories); ?></div>
                            <p class="text-gray-600">Categories</p>
                        </div>
                        <!-- <div class="text-center">
                            <div class="text-3xl font-bold text-secondary mb-2">
                                < ?php echo array_sum($categoryCounts); ?></div>
                            <p class="text-gray-600">Database Entries</p>
                        </div> -->
                        <div class="text-center">
                            <div class="text-3xl font-bold text-emerald-600 mb-2">100%</div>
                            <p class="text-gray-600">Verified Solutions</p>
                        </div>
                    </div>

                    <!-- Search Bar -->
                    <div class="relative">
                        <input type="text" id="searchInput" placeholder="Search innovations by name or description..."
                            class="w-full px-6 py-4 rounded-full border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary focus:ring-opacity-50 focus:outline-none transition-colors duration-300">
                        <i class="fas fa-search absolute right-6 top-4 text-gray-400"></i>
                    </div>
                </div>

                <!-- Category Filter -->
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Filter by Category</h2>
                    <div class="flex flex-wrap gap-2">
                        <button
                            class="category-filter px-4 py-2 rounded-full bg-primary text-white font-medium hover:bg-primary/90 transition-colors duration-300 <?php echo !$categoryFilter ? 'ring-2 ring-offset-2 ring-primary' : ''; ?>"
                            data-category="">
                            All Categories (<?php echo array_sum($categoryCounts); ?>)
                        </button>
                        <?php foreach ($categories as $cat):
                            $catName = $cat['category'];
                            $config = $categoryConfig[$catName] ?? [
                                'bg' => 'bg-gray-100',
                                'text' => 'text-gray-800',
                                'border' => 'border-gray-200'
                            ];
                            $isActive = $categoryFilter === strtolower($catName);
                            ?>
                            <button
                                class="category-filter px-4 py-2 rounded-full font-medium transition-all duration-300 <?php echo $isActive ? 'ring-2 ring-offset-2 ring-primary' : ''; ?> <?php echo $config['bg']; ?> <?php echo $config['text']; ?> border <?php echo $config['border']; ?> hover:opacity-90"
                                data-category="<?php echo strtolower($catName); ?>">
                                <?php echo $catName; ?> (<?php echo $categoryCounts[$catName] ?? 0; ?>)
                            </button>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Innovations Grid -->
                <div id="innovationsGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($innovations as $innovation):
                        $config = $categoryConfig[$innovation['category']] ?? [
                            'bg' => 'bg-gray-100',
                            'text' => 'text-gray-800',
                            'border' => 'border-gray-200',
                            'gradient' => 'from-gray-400 to-gray-500',
                            'icon' => 'fas fa-lightbulb',
                            'iconBg' => 'bg-gray-50'
                        ];

                        $truncatedDesc = strlen($innovation['description']) > 100
                            ? substr($innovation['description'], 0, 100) . '...'
                            : $innovation['description'];
                        ?>
                        <div class="innovation-card group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-<?php echo explode('-', $config['bg'])[1]; ?>-300"
                            data-category="<?php echo strtolower($innovation['category']); ?>"
                            data-name="<?php echo htmlspecialchars(strtolower($innovation['startup_name'])); ?>"
                            data-description="<?php echo htmlspecialchars(strtolower($innovation['description'])); ?>">
                            <div class="h-2 bg-gradient-to-r <?php echo $config['gradient']; ?>"></div>
                            <div class="p-6">
                                <!-- Header -->
                                <div class="flex items-start justify-between mb-4">
                                    <div class="flex items-center">
                                        <div
                                            class="w-12 h-12 rounded-xl <?php echo $config['iconBg']; ?> flex items-center justify-center mr-4">
                                            <i class="<?php echo $config['icon']; ?> <?php echo $config['text']; ?>"></i>
                                        </div>
                                        <div>
                                            <h3
                                                class="text-lg font-bold text-gray-800 group-hover:text-<?php echo explode('-', $config['text'])[1]; ?>-700 transition-colors duration-300">
                                                <?php echo htmlspecialchars($innovation['startup_name']); ?>
                                            </h3>
                                            <span
                                                class="<?php echo $config['bg']; ?> <?php echo $config['text']; ?> text-xs font-bold px-3 py-1 rounded-full border <?php echo $config['border']; ?> mt-1 inline-block">
                                                <?php echo htmlspecialchars($innovation['category']); ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="text-sm text-gray-500 font-mono">#<?php echo $innovation['id']; ?></div>
                                </div>

                                <!-- Description -->
                                <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                                    <?php echo htmlspecialchars($truncatedDesc); ?>
                                </p>

                                <!-- Actions -->
                                <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                    <a href="innovation-details.php?id=<?php echo $innovation['id']; ?>"
                                        class="inline-flex items-center text-<?php echo explode('-', $config['text'])[1]; ?>-600 hover:text-<?php echo explode('-', $config['text'])[1]; ?>-800 font-medium text-sm transition-colors duration-300 group/view">
                                        <span>View Details</span>
                                        <div
                                            class="ml-2 w-8 h-8 rounded-full <?php echo $config['iconBg']; ?> flex items-center justify-center group-hover/view:scale-110 transition-transform duration-300">
                                            <i class="fas fa-arrow-right <?php echo $config['text']; ?>"></i>
                                        </div>
                                    </a>

                                    <?php if ($innovation['website_url']): ?>
                                        <a href="<?php echo htmlspecialchars($innovation['website_url']); ?>" target="_blank"
                                            class="w-10 h-10 rounded-full <?php echo $config['iconBg']; ?> flex items-center justify-center text-gray-600 hover:text-<?php echo explode('-', $config['text'])[1]; ?>-700 hover:scale-110 transition-all duration-300"
                                            title="Visit Website">
                                            <i class="fas fa-external-link-alt"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- No Results Message -->
                <div id="noResults" class="hidden text-center py-16">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-search text-gray-400 text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-600 mb-3">No Innovations Found</h3>
                    <p class="text-gray-500 mb-8 max-w-md mx-auto">
                        Try adjusting your search or filter criteria to find what you're looking for.
                    </p>
                    <button onclick="clearFilters()"
                        class="px-6 py-3 bg-primary text-white font-semibold rounded-full hover:bg-primary/90 transition-colors duration-300">
                        Clear All Filters
                    </button>
                </div>

                <!-- View Count -->
                <div class="text-center mt-12 pt-8 border-t border-gray-200">
                    <p class="text-gray-600">
                        Showing <span id="visibleCount"
                            class="font-bold text-primary"><?php echo count($innovations); ?></span>
                        of <span class="font-bold"><?php echo array_sum($categoryCounts); ?></span> total innovations
                    </p>
                </div>
            </div>
        </section>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const searchInput = document.getElementById('searchInput');
                const categoryFilters = document.querySelectorAll('.category-filter');
                const innovationCards = document.querySelectorAll('.innovation-card');
                const innovationsGrid = document.getElementById('innovationsGrid');
                const noResults = document.getElementById('noResults');
                const visibleCount = document.getElementById('visibleCount');

                let activeCategory = '<?php echo $categoryFilter; ?>';

                function filterInnovations() {
                    const searchTerm = searchInput.value.toLowerCase();
                    let visibleCards = 0;

                    innovationCards.forEach(card => {
                        const cardCategory = card.dataset.category;
                        const cardName = card.dataset.name;
                        const cardDescription = card.dataset.description;

                        const matchesCategory = !activeCategory || cardCategory === activeCategory;
                        const matchesSearch = !searchTerm ||
                            cardName.includes(searchTerm) ||
                            cardDescription.includes(searchTerm);

                        if (matchesCategory && matchesSearch) {
                            card.style.display = 'block';
                            visibleCards++;

                            // Add animation for appearing cards
                            card.style.animation = 'fadeIn 0.5s ease';
                        } else {
                            card.style.display = 'none';
                        }
                    });

                    // Update visible count
                    visibleCount.textContent = visibleCards;

                    // Show/hide no results message
                    if (visibleCards === 0) {
                        innovationsGrid.style.display = 'none';
                        noResults.style.display = 'block';
                    } else {
                        innovationsGrid.style.display = 'grid';
                        noResults.style.display = 'none';
                    }
                }

                // Search functionality
                searchInput.addEventListener('input', filterInnovations);

                // Category filter functionality
                categoryFilters.forEach(button => {
                    button.addEventListener('click', function () {
                        activeCategory = this.dataset.category;

                        // Update URL without page reload
                        const url = new URL(window.location);
                        if (activeCategory) {
                            url.searchParams.set('category', activeCategory);
                        } else {
                            url.searchParams.delete('category');
                        }
                        window.history.pushState({}, '', url);

                        // Update active button styles
                        categoryFilters.forEach(btn => {
                            const isActive = btn.dataset.category === activeCategory;
                            btn.classList.toggle('ring-2', isActive);
                            btn.classList.toggle('ring-offset-2', isActive);
                            btn.classList.toggle('ring-primary', isActive);
                        });

                        filterInnovations();
                    });
                });

                // Clear filters function
                window.clearFilters = function () {
                    searchInput.value = '';
                    activeCategory = '';

                    // Reset category filter buttons
                    categoryFilters.forEach(btn => {
                        const isActive = btn.dataset.category === activeCategory;
                        btn.classList.toggle('ring-2', isActive);
                        btn.classList.toggle('ring-offset-2', isActive);
                        btn.classList.toggle('ring-primary', isActive);
                    });

                    // Update URL
                    const url = new URL(window.location);
                    url.searchParams.delete('category');
                    window.history.pushState({}, '', url);

                    filterInnovations();
                };

                // Handle browser back/forward buttons
                window.addEventListener('popstate', function () {
                    const urlParams = new URLSearchParams(window.location.search);
                    activeCategory = urlParams.get('category') || '';

                    // Update UI to match URL state
                    categoryFilters.forEach(btn => {
                        const isActive = btn.dataset.category === activeCategory;
                        btn.classList.toggle('ring-2', isActive);
                        btn.classList.toggle('ring-offset-2', isActive);
                        btn.classList.toggle('ring-primary', isActive);
                    });

                    filterInnovations();
                });

                // Initialize
                filterInnovations();
            });
        </script>

        <style>
            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(10px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .line-clamp-3 {
                display: -webkit-box;
                -webkit-line-clamp: 3;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }

            .innovation-card {
                animation: fadeIn 0.5s ease;
            }

            /* Smooth transitions */
            button,
            a,
            input {
                transition: all 0.3s ease;
            }

            /* Custom scrollbar for search results */
            #innovationsGrid {
                transition: all 0.3s ease;
            }
        </style>
    </section>

    <!-- < ?php include 'sections/patners.php'; ?> -->
 

    <!-- Footer -->
    <?php
    include 'sections/footer.php';
    include 'chatbot.php';

    if ($con) {
        mysqli_close($con);
    }
    ?>

    <script>
        $(document).ready(function () {
            // Initialize DataTable with pagination
            var table = $('#contactTable').DataTable({
                paging: true,
                pageLength: 10,
                searching: true,
                ordering: true,
                responsive: true,
                language: {
                    search: "Search:",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    paginate: {
                        previous: "←",
                        next: "→"
                    }
                }
            });

            // Filter functionality
            $('#regionFilter').on('change', function () {
                table.column(1).search(this.value).draw();
            });

            $('#countyFilter').on('change', function () {
                table.column(2).search(this.value).draw();
            });

            $('#constituencyFilter').on('change', function () {
                table.column(3).search(this.value).draw();
            });

            // Reset filters
            $('#resetFilters').on('click', function () {
                $('#regionFilter, #countyFilter, #constituencyFilter').val('');
                table.columns().search('').draw();
            });
        });
    </script>

    <!-- scripts -->
    <script src="sources/scripts/script.js"></script>
</body>

</html>