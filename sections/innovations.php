<?php
include 'connect.php';

// Get 6 random innovations
$query = "SELECT id, startup_name, description, website_url, category FROM innovation ORDER BY RAND() LIMIT 6";
$result = mysqli_query($con, $query);
$innovations = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Get total count for button text
$countQuery = "SELECT COUNT(*) as total FROM innovation";
$countResult = mysqli_query($con, $countQuery);
$totalCount = mysqli_fetch_assoc($countResult)['total'];
?>

<section id="innovations" class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center text-accent mb-4">Featured Innovations</h2>
        <p class="text-lg text-gray-600 text-center mb-12 max-w-2xl mx-auto">Discover the innovative solutions we're supporting through our program</p>

        <!-- Innovation Carousel -->
        <div class="innovation-carousel-wrapper relative">
            <div class="innovation-carousel-inner flex transition-transform duration-500 ease-in-out">
                <?php foreach ($innovations as $index => $innovation): 
                    // Enhanced category configuration with larger, more visible icons
                    $categoryConfig = [
                        'AgriTech' => [
                            'bg' => 'bg-emerald-50',
                            'text' => 'text-emerald-800',
                            'border' => 'border-emerald-200',
                            'gradient' => 'from-emerald-400 to-green-500',
                            'icon' => 'fas fa-leaf',
                            'iconBg' => 'bg-emerald-100',
                            'iconColor' => 'text-emerald-600',
                            'iconSize' => 'text-3xl'
                        ],
                        'FinTech' => [
                            'bg' => 'bg-indigo-50',
                            'text' => 'text-indigo-800',
                            'border' => 'border-indigo-200',
                            'gradient' => 'from-indigo-400 to-blue-500',
                            'icon' => 'fas fa-coins',
                            'iconBg' => 'bg-indigo-100',
                            'iconColor' => 'text-indigo-600',
                            'iconSize' => 'text-3xl'
                        ],
                        'HealthTech' => [
                            'bg' => 'bg-rose-50',
                            'text' => 'text-rose-800',
                            'border' => 'border-rose-200',
                            'gradient' => 'from-rose-400 to-pink-500',
                            'icon' => 'fas fa-heartbeat',
                            'iconBg' => 'bg-rose-100',
                            'iconColor' => 'text-rose-600',
                            'iconSize' => 'text-3xl'
                        ],
                        'EduTech' => [
                            'bg' => 'bg-violet-50',
                            'text' => 'text-violet-800',
                            'border' => 'border-violet-200',
                            'gradient' => 'from-violet-400 to-purple-500',
                            'icon' => 'fas fa-graduation-cap',
                            'iconBg' => 'bg-violet-100',
                            'iconColor' => 'text-violet-600',
                            'iconSize' => 'text-3xl'
                        ],
                        'LogiTech' => [
                            'bg' => 'bg-amber-50',
                            'text' => 'text-amber-800',
                            'border' => 'border-amber-200',
                            'gradient' => 'from-amber-400 to-orange-500',
                            'icon' => 'fas fa-truck',
                            'iconBg' => 'bg-amber-100',
                            'iconColor' => 'text-amber-600',
                            'iconSize' => 'text-3xl'
                        ],
                        'GreenTech' => [
                            'bg' => 'bg-teal-50',
                            'text' => 'text-teal-800',
                            'border' => 'border-teal-200',
                            'gradient' => 'from-teal-400 to-emerald-500',
                            'icon' => 'fas fa-sun',
                            'iconBg' => 'bg-teal-100',
                            'iconColor' => 'text-teal-600',
                            'iconSize' => 'text-3xl'
                        ],
                        'MarketTech' => [
                            'bg' => 'bg-fuchsia-50',
                            'text' => 'text-fuchsia-800',
                            'border' => 'border-fuchsia-200',
                            'gradient' => 'from-fuchsia-400 to-purple-500',
                            'icon' => 'fas fa-store',
                            'iconBg' => 'bg-fuchsia-100',
                            'iconColor' => 'text-fuchsia-600',
                            'iconSize' => 'text-3xl'
                        ],
                        'GovTech' => [
                            'bg' => 'bg-slate-50',
                            'text' => 'text-slate-800',
                            'border' => 'border-slate-200',
                            'gradient' => 'from-slate-400 to-gray-500',
                            'icon' => 'fas fa-landmark',
                            'iconBg' => 'bg-slate-100',
                            'iconColor' => 'text-slate-600',
                            'iconSize' => 'text-3xl'
                        ]
                    ];
                    
                    // Default configuration for unknown categories
                    $defaultConfig = [
                        'bg' => 'bg-gray-50',
                        'text' => 'text-gray-800',
                        'border' => 'border-gray-200',
                        'gradient' => 'from-gray-400 to-gray-500',
                        'icon' => 'fas fa-lightbulb',
                        'iconBg' => 'bg-gray-100',
                        'iconColor' => 'text-gray-600',
                        'iconSize' => 'text-3xl'
                    ];
                    
                    $config = $categoryConfig[$innovation['category']] ?? $defaultConfig;
                    
                    // Truncate text for display
                    $truncatedName = strlen($innovation['startup_name']) > 40 
                        ? substr($innovation['startup_name'], 0, 40) . '...' 
                        : $innovation['startup_name'];
                    
                    $truncatedDesc = strlen($innovation['description']) > 120 
                        ? substr($innovation['description'], 0, 120) . '...' 
                        : $innovation['description'];
                ?>
                <div class="innovation-slide w-full md:w-1/2 lg:w-1/3 flex-shrink-0 px-4">
                    <div class="group bg-white rounded-2xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:border-<?php echo explode('-', $config['bg'])[1]; ?>-300 h-full">
                        <!-- Top gradient banner -->
                        <div class="h-3 bg-gradient-to-r <?php echo $config['gradient']; ?>"></div>
                        
                        <!-- Main content with icon prominently displayed -->
                        <div class="p-6">
                            <!-- Icon and category in header -->
                            <div class="flex items-start justify-between mb-6">
                                <!-- Large visible icon -->
                                <div class="flex items-center">
                                    <div class="w-16 h-16 rounded-2xl <?php echo $config['iconBg']; ?> flex items-center justify-center shadow-md mr-4">
                                        <i class="<?php echo $config['icon']; ?> <?php echo $config['iconColor']; ?> <?php echo $config['iconSize']; ?>"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-bold text-gray-800 group-hover:text-<?php echo explode('-', $config['text'])[1]; ?>-700 transition-colors duration-300"
                                            title="<?php echo htmlspecialchars($innovation['startup_name']); ?>">
                                            <?php echo htmlspecialchars($truncatedName); ?>
                                        </h3>
                                        <div class="flex items-center mt-1">
                                            <span class="<?php echo $config['bg']; ?> <?php echo $config['text']; ?> text-xs font-bold px-3 py-1.5 rounded-full border <?php echo $config['border']; ?>">
                                                <?php echo htmlspecialchars($innovation['category']); ?>
                                            </span>
                                            <span class="ml-2 text-sm text-gray-500">
                                                <i class="fas fa-star text-amber-400"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Description -->
                            <p class="text-gray-600 mb-6 line-clamp-3 text-sm leading-relaxed border-l-4 <?php echo $config['border']; ?> pl-4 py-1">
                                <?php echo htmlspecialchars($truncatedDesc); ?>
                            </p>
                            
                            <!-- Actions -->
                            <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                <a href="innovation-details.php?id=<?php echo $innovation['id']; ?>" 
                                   class="inline-flex items-center font-medium text-sm transition-all duration-300 group/view">
                                    <span class="text-<?php echo explode('-', $config['text'])[1]; ?>-600 group-hover:text-<?php echo explode('-', $config['text'])[1]; ?>-800 font-semibold">
                                        View Details
                                    </span>
                                    <div class="ml-3 w-8 h-8 rounded-full <?php echo $config['iconBg']; ?> flex items-center justify-center group-hover/view:scale-110 transition-transform duration-300">
                                        <i class="fas fa-arrow-right <?php echo $config['iconColor']; ?>"></i>
                                    </div>
                                </a>
                                
                                <?php if ($innovation['website_url']): ?>
                                <a href="<?php echo htmlspecialchars($innovation['website_url']); ?>" 
                                   target="_blank" 
                                   class="w-10 h-10 rounded-full <?php echo $config['iconBg']; ?> flex items-center justify-center text-gray-600 hover:text-<?php echo explode('-', $config['text'])[1]; ?>-700 hover:scale-110 transition-all duration-300"
                                   title="Visit Website">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <!-- Bottom accent bar -->
                        <div class="h-1 <?php echo $config['bg']; ?>"></div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <!-- Navigation Buttons -->
            <button class="innovation-carousel-prev absolute left-0 top-1/2 transform -translate-y-1/2 -translate-x-2 bg-white w-12 h-12 rounded-full shadow-2xl flex items-center justify-center hover:bg-gray-50 transition-all duration-300 z-10 hover:scale-110 hover:shadow-3xl">
                <i class="fas fa-chevron-left text-primary text-xl"></i>
            </button>
            <button class="innovation-carousel-next absolute right-0 top-1/2 transform -translate-y-1/2 translate-x-2 bg-white w-12 h-12 rounded-full shadow-2xl flex items-center justify-center hover:bg-gray-50 transition-all duration-300 z-10 hover:scale-110 hover:shadow-3xl">
                <i class="fas fa-chevron-right text-primary text-xl"></i>
            </button>
            
            <!-- Dots Indicator -->
            <div class="flex justify-center mt-8 space-x-3">
                <?php for($i = 0; $i < count($innovations); $i++): ?>
                <button class="innovation-carousel-dot w-4 h-4 rounded-full transition-all duration-300 hover:scale-125 <?php echo $i === 0 ? 'bg-primary scale-125 shadow-lg' : 'bg-gray-300 hover:bg-gray-400'; ?>" 
                        data-index="<?php echo $i; ?>"></button>
                <?php endfor; ?>
            </div>
        </div>

        <!-- View All Innovations Button -->
        <div class="text-center mt-12">
            <a href="all-innovations.php"
                class="group inline-flex items-center text-white border border-danger bg-danger rounded-full px-8 py-4 font-bold hover:text-danger hover:bg-white hover:border-danger transition-all duration-300 shadow-2xl hover:shadow-3xl transform hover:-translate-y-1">
                <div class="w-10 h-10 rounded-full bg-white bg-opacity-20 flex items-center justify-center mr-3 group-hover:bg-danger group-hover:bg-opacity-10 transition-all duration-300">
                    <i class="fas fa-lightbulb text-white group-hover:text-danger"></i>
                </div>
                <span>Explore All <?php echo $totalCount; ?>+ Innovations</span>
                <div class="ml-4 w-10 h-10 rounded-full bg-white bg-opacity-20 flex items-center justify-center group-hover:bg-danger group-hover:bg-opacity-10 transition-all duration-300">
                    <i class="fas fa-arrow-right text-white group-hover:text-danger transform group-hover:translate-x-1 transition-transform duration-300"></i>
                </div>
            </a>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.querySelector('.innovation-carousel-inner');
    const slides = document.querySelectorAll('.innovation-slide');
    const dots = document.querySelectorAll('.innovation-carousel-dot');
    const prevBtn = document.querySelector('.innovation-carousel-prev');
    const nextBtn = document.querySelector('.innovation-carousel-next');
    
    let currentSlide = 0;
    const slidesPerView = getSlidesPerView();
    const totalSlides = slides.length;
    
    function getSlidesPerView() {
        const width = window.innerWidth;
        if (width >= 1024) return 3; // Desktop: 3 slides
        if (width >= 768) return 2;  // Tablet: 2 slides
        return 1; // Mobile: 1 slide
    }
    
    function updateCarousel() {
        const slideWidth = 100 / slidesPerView;
        const translateX = -currentSlide * slideWidth;
        container.style.transform = `translateX(${translateX}%)`;
        
        // Update dots
        const maxSlide = Math.max(0, totalSlides - slidesPerView);
        const activeDotIndex = Math.min(currentSlide, maxSlide);
        
        dots.forEach((dot, index) => {
            const isActive = index === activeDotIndex;
            dot.classList.toggle('bg-primary', isActive);
            dot.classList.toggle('bg-gray-300', !isActive);
            dot.classList.toggle('scale-125', isActive);
            dot.classList.toggle('scale-100', !isActive);
            dot.classList.toggle('shadow-lg', isActive);
        });
    }
    
    function nextSlide() {
        const maxSlide = Math.max(0, totalSlides - slidesPerView);
        currentSlide = currentSlide >= maxSlide ? 0 : currentSlide + 1;
        updateCarousel();
    }
    
    function prevSlide() {
        const maxSlide = Math.max(0, totalSlides - slidesPerView);
        currentSlide = currentSlide <= 0 ? maxSlide : currentSlide - 1;
        updateCarousel();
    }
    
    function goToSlide(index) {
        const maxSlide = Math.max(0, totalSlides - slidesPerView);
        currentSlide = Math.min(index, maxSlide);
        updateCarousel();
    }
    
    // Event Listeners
    prevBtn.addEventListener('click', prevSlide);
    nextBtn.addEventListener('click', nextSlide);
    
    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => goToSlide(index));
    });
    
    // Keyboard Navigation
    document.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowLeft') prevSlide();
        if (e.key === 'ArrowRight') nextSlide();
    });
    
    // Auto-slide every 5 seconds
    let autoSlide = setInterval(nextSlide, 5000);
    
    // Pause auto-slide on hover
    const carouselWrapper = document.querySelector('.innovation-carousel-wrapper');
    carouselWrapper.addEventListener('mouseenter', () => clearInterval(autoSlide));
    carouselWrapper.addEventListener('mouseleave', () => {
        autoSlide = setInterval(nextSlide, 5000);
    });
    
    // Handle window resize
    let resizeTimeout;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(() => {
            updateCarousel();
        }, 250);
    });
    
    // Initialize
    updateCarousel();
    
    // Touch/swipe support for mobile
    let startX = 0;
    let endX = 0;
    
    container.addEventListener('touchstart', (e) => {
        startX = e.touches[0].clientX;
    });
    
    container.addEventListener('touchend', (e) => {
        endX = e.changedTouches[0].clientX;
        const diff = startX - endX;
        
        if (Math.abs(diff) > 50) {
            if (diff > 0) {
                nextSlide();
            } else {
                prevSlide();
            }
        }
    });
    
    // Add subtle animation to cards on load
    slides.forEach((slide, index) => {
        slide.style.opacity = '0';
        slide.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            slide.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            slide.style.opacity = '1';
            slide.style.transform = 'translateY(0)';
        }, index * 100);
    });
});
</script>

<style>
.innovation-carousel-wrapper {
    position: relative;
    overflow: hidden;
    padding: 0 20px;
}

.innovation-carousel-inner {
    display: flex;
    transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
}

.innovation-slide {
    flex: 0 0 auto;
    transition: transform 0.3s ease;
}

.innovation-carousel-dot {
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.innovation-carousel-dot.bg-primary {
    transform: scale(1.25);
    box-shadow: 0 0 10px rgba(59, 130, 246, 0.5);
}

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

@media (max-width: 768px) {
    .innovation-carousel-prev,
    .innovation-carousel-next {
        display: none;
    }
    
    .innovation-carousel-wrapper {
        padding: 0;
    }
    
    .innovation-slide {
        padding-left: 0.5rem;
        padding-right: 0.5rem;
    }
}

/* Custom icon sizes and visibility */
.fa-leaf, .fa-coins, .fa-heartbeat, .fa-graduation-cap,
.fa-truck, .fa-sun, .fa-store, .fa-landmark {
    filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
}

/* Ensure icons are always visible */
.w-16.h-16 {
    min-width: 4rem;
    min-height: 4rem;
}

/* Enhanced hover effects */
.group:hover .w-16.h-16 {
    transform: scale(1.05);
    transition: transform 0.3s ease;
}

/* Card hover effect */
.innovation-slide:hover {
    z-index: 10;
}

/* Animation for newly loaded cards */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>