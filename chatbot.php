<!-- Back to Top Button -->
<button onclick="window.scrollTo({top: 0, behavior: 'smooth'})" id="back-to-top"
    class="fixed bottom-6 left-6 w-12 h-12 bg-[#006600] text-white rounded-full shadow-lg flex items-center justify-center hover:shadow-xl transition-all duration-300 hover:scale-110 z-40 hover:bg-[#004d00]">
    <i class="fas fa-chevron-up"></i>
</button>

<style>
    /* Custom Colors */
    :root {
        --primary: #000000;
        --accent: #006600;
        --dark: #0f172a;
        --danger: #DE2910;
        --light: #f8fafc;
        --black: #000000;
        --accent-light: #008800;
        --accent-dark: #004400;
        --accent-transparent: rgba(0, 102, 0, 0.1);
    }

    /* Animations */
    @keyframes slideInRight {
        from {
            transform: translateX(20px);
            opacity: 0;
        }

        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes slideInLeft {
        from {
            transform: translateX(-20px);
            opacity: 0;
        }

        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes bounce {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-5px);
        }
    }

    @keyframes typing {

        0%,
        60%,
        100% {
            opacity: 0.4;
            transform: translateY(0);
        }

        30% {
            opacity: 1;
            transform: translateY(-2px);
        }
    }

    @keyframes pulse-green {

        0%,
        100% {
            box-shadow: 0 0 0 0 rgba(0, 102, 0, 0.4);
        }

        50% {
            box-shadow: 0 0 0 10px rgba(0, 102, 0, 0);
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Animation Classes */
    .animate-slide-in-right {
        animation: slideInRight 0.3s ease-out;
    }

    .animate-slide-in-left {
        animation: slideInLeft 0.3s ease-out;
    }

    .animate-bounce {
        animation: bounce 2s infinite;
    }

    .animate-pulse-green {
        animation: pulse-green 2s infinite;
    }

    .animate-fade-in {
        animation: fadeIn 0.3s ease-out;
    }

    .typing-dot {
        animation: typing 1.4s infinite ease-in-out;
    }

    /* Color Classes */
    .bg-primary {
        background-color: var(--primary);
    }

    .bg-accent {
        background-color: var(--accent);
    }

    .bg-dark {
        background-color: var(--dark);
    }

    .bg-danger {
        background-color: var(--danger);
    }

    .bg-light {
        background-color: var(--light);
    }

    .bg-accent-light {
        background-color: var(--accent-light);
    }

    .bg-accent-dark {
        background-color: var(--accent-dark);
    }

    .bg-accent-transparent {
        background-color: var(--accent-transparent);
    }

    .text-primary {
        color: var(--primary);
    }

    .text-accent {
        color: var(--accent);
    }

    .text-dark {
        color: var(--dark);
    }

    .text-danger {
        color: var(--danger);
    }

    .text-light {
        color: var(--light);
    }

    /* Gradient Classes */
    .gradient-accent {
        background: linear-gradient(135deg, var(--accent) 0%, var(--accent-light) 100%);
    }

    .gradient-dark {
        background: linear-gradient(135deg, var(--dark) 0%, #1e293b 100%);
    }

    /* Message Bubbles */
    .message-bubble {
        max-width: 70%;
        padding: 10px 14px;
        border-radius: 18px;
        margin: 6px 0;
        position: relative;
        word-wrap: break-word;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    }

    .message-bubble.user {
        background: linear-gradient(135deg, var(--accent) 0%, var(--accent-light) 100%);
        color: white;
        margin-left: auto;
        border-bottom-right-radius: 4px;
    }

    .message-bubble.bot {
        background: white;
        margin-right: auto;
        border-bottom-left-radius: 4px;
        border: 1px solid rgba(0, 0, 0, 0.08);
    }

    /* Status Indicators */
    .status-indicator {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 6px;
    }

    .status-online {
        background-color: var(--accent);
        animation: pulse-green 2s infinite;
    }

    .status-typing {
        background-color: #FFA500;
    }

    .status-offline {
        background-color: #666;
    }

    /* Chat Container States */
    .chat-minimized {
        height: 60px;
        width: 350px;
        bottom: 100px;
    }

    .chat-maximized {
        width: 90vw;
        height: 90vh;
        max-width: 1200px;
        max-height: 800px;
        bottom: 20px;
        right: 20px;
    }

    .chat-normal {
        width: 380px;
        height: 600px;
    }

    /* Custom Scrollbar */
    .scrollbar-green::-webkit-scrollbar {
        width: 6px;
    }

    .scrollbar-green::-webkit-scrollbar-track {
        background: rgba(0, 102, 0, 0.05);
        border-radius: 10px;
    }

    .scrollbar-green::-webkit-scrollbar-thumb {
        background: linear-gradient(135deg, var(--accent) 0%, var(--accent-light) 100%);
        border-radius: 10px;
    }

    /* Menu Styles */
    .menu-item {
        padding: 12px 16px;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 12px;
        color: var(--dark);
    }

    .menu-item:hover {
        background-color: rgba(0, 102, 0, 0.05);
    }

    .menu-divider {
        height: 1px;
        background-color: rgba(0, 0, 0, 0.1);
        margin: 4px 0;
    }

    /* Quick Actions - Collapsible */
    .quick-actions-section {
        transition: all 0.3s ease;
        overflow: hidden;
    }

    .quick-actions-section.minimized {
        padding-top: 8px;
        padding-bottom: 8px;
    }

    .quick-actions-section.minimized .quick-actions-grid {
        max-height: 0;
        opacity: 0;
        margin-top: 0;
        pointer-events: none;
    }

    .quick-actions-section:not(.minimized) .quick-actions-grid {
        max-height: 200px;
        opacity: 1;
        margin-top: 12px;
        pointer-events: auto;
    }

    .quick-actions-toggle {
        cursor: pointer;
        user-select: none;
        transition: all 0.3s;
    }

    .quick-actions-toggle:hover {
        opacity: 0.8;
    }

    .quick-actions-toggle .toggle-icon {
        transition: transform 0.3s ease;
    }

    .quick-actions-section.minimized .toggle-icon {
        transform: rotate(-90deg);
    }

    .quick-action-card {
        background: white;
        border-radius: 12px;
        padding: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
        border: 1px solid rgba(0, 102, 0, 0.1);
        min-width: 120px;
        flex: 1;
        opacity: 0;
        transform: translateY(10px);
        animation: fadeIn 0.3s ease-out forwards;
    }

    .quick-action-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 102, 0, 0.1);
        border-color: var(--accent);
    }

    .quick-action-card .icon-wrapper {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 8px;
    }

    /* Floating Menu */
    .floating-menu {
        position: absolute;
        background: white;
        border-radius: 8px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        min-width: 200px;
        z-index: 1000;
        overflow: hidden;
        border: 1px solid rgba(0, 102, 0, 0.1);
    }

    /* Timestamp */
    .message-time {
        font-size: 11px;
        opacity: 0.7;
        text-align: right;
        margin-top: 4px;
    }

    /* User Avatar */
    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        background: linear-gradient(135deg, var(--accent) 0%, var(--accent-light) 100%);
        color: white;
    }

    /* Input Styling */
    .chat-input {
        background: white;
        border: 1px solid rgba(0, 102, 0, 0.2);
        border-radius: 20px;
        transition: all 0.3s;
    }

    .chat-input:focus {
        border-color: var(--accent);
        box-shadow: 0 0 0 2px rgba(0, 102, 0, 0.1);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .chat-normal {
            width: calc(100vw - 32px);
            height: 70vh;
            right: 16px;
        }

        .chat-maximized {
            width: 100vw;
            height: 100vh;
            max-width: none;
            max-height: none;
            border-radius: 0;
            bottom: 0;
            right: 0;
        }

        .quick-action-card {
            min-width: 100px;
        }
    }

    /* Typing Animation */
    .typing-container {
        display: flex;
        align-items: center;
        gap: 3px;
        padding: 6px 12px;
        background: white;
        border-radius: 18px;
        width: fit-content;
    }

    /* Action Button */
    .action-button {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
    }

    .action-button:hover {
        background-color: rgba(0, 102, 0, 0.1);
        transform: scale(1.1);
    }

    /* Header Gradient */
    .header-gradient {
        background: linear-gradient(135deg, var(--dark) 0%, #1e293b 50%, var(--accent-dark) 100%);
    }

    /* Quick Action Bar (Minimized State) */
    .quick-actions-bar {
        display: flex;
        gap: 8px;
        overflow-x: auto;
        padding: 8px 0;
        scrollbar-width: none;
        -ms-overflow-style: none;
        margin-top: 8px;
    }

    .quick-actions-bar::-webkit-scrollbar {
        display: none;
    }

    .quick-action-mini {
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 6px 10px;
        background: white;
        border-radius: 20px;
        border: 1px solid rgba(0, 102, 0, 0.1);
        font-size: 12px;
        white-space: nowrap;
        cursor: pointer;
        transition: all 0.2s;
        flex-shrink: 0;
    }

    .quick-action-mini:hover {
        background: var(--accent-transparent);
        border-color: var(--accent);
        transform: translateY(-1px);
    }

    .quick-action-mini i {
        font-size: 14px;
    }

    /* Quick Actions - Collapsed by default styles */
    .quick-actions-section.collapsed-by-default {
        padding-top: 8px;
        padding-bottom: 8px;
    }

    .quick-actions-section.collapsed-by-default .quick-actions-grid {
        max-height: 0;
        opacity: 0;
        margin-top: 0;
        pointer-events: none;
    }

    .quick-actions-section.collapsed-by-default .toggle-icon {
        transform: rotate(-90deg);
    }

    .quick-actions-section.collapsed-by-default .quick-actions-bar {
        display: flex;
    }

    .quick-actions-section:not(.collapsed-by-default) .quick-actions-bar {
        display: none;
    }
</style>

<!-- Green Themed Chatbot Icon -->
<div class="fixed bottom-6 right-6 w-16 h-16 rounded-full flex items-center justify-center cursor-pointer z-50 transition-all duration-300 hover:scale-110 group animate-bounce"
    id="chatbot-icon">

    <!-- Green Gradient Circle -->
    <div class="absolute inset-0 rounded-full gradient-accent animate-pulse-green"></div>

    <!-- Inner White Circle -->
    <div class="absolute inset-2 rounded-full bg-white flex items-center justify-center">
        <i class="fas fa-comments text-2xl text-accent"></i>
    </div>

    <!-- Green Glow Effect -->
    <div class="absolute -inset-2 rounded-full bg-accent opacity-20 blur-sm group-hover:opacity-30 transition-opacity">
    </div>

    <!-- Notification Badge -->
    <div
        class="absolute -top-1 -right-1 w-6 h-6 bg-danger rounded-full flex items-center justify-center text-white text-xs font-bold shadow-lg">
        <i class="fas fa-bell"></i>
    </div>

    <!-- Hover Tooltip -->
    <div
        class="absolute -top-12 right-0 bg-dark text-white px-3 py-2 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap animate-slide-in-right">
        <div class="flex items-center gap-2">
            <div class="status-indicator status-online"></div>
            <span class="text-sm">Whitebox Assistant</span>
        </div>
        <div class="absolute w-2 h-2 bg-dark transform rotate-45 -bottom-1 right-4"></div>
    </div>
</div>

<!-- Green Themed Chat Container -->
<div class="fixed bottom-24 right-6 bg-white rounded-2xl shadow-2xl flex flex-col z-60 opacity-0 translate-y-5 pointer-events-none transition-all duration-300 overflow-hidden border border-accent/20 chat-normal"
    id="chatbot-container">

    <!-- Header - Dark with Green Accent -->
    <div class="header-gradient p-4 flex items-center justify-between">
        <!-- Left Side: Contact Info -->
        <div class="flex items-center gap-3">
            <!-- Avatar -->
            <div class="user-avatar">
                <i class="fas fa-robot text-lg"></i>
            </div>

            <!-- Contact Details -->
            <div>
                <h3 class="font-semibold text-white">Whitebox Assistant</h3>
                <div class="flex items-center gap-1">
                    <span class="status-indicator status-online"></span>
                    <span class="text-white/90 text-sm" id="status-text">Online</span>
                    <span class="text-white/90 text-sm hidden" id="typing-text">• typing...</span>
                </div>
            </div>
        </div>

        <!-- Right Side: Action Buttons -->
        <div class="flex items-center gap-2">
            <!-- Maximize Button -->
            <button class="action-button text-white hover:text-accent-light" id="maximize-button" title="Maximize">
                <i class="fas fa-expand text-sm"></i>
            </button>

            <!-- Menu Button -->
            <div class="relative">
                <button class="action-button text-white hover:text-accent-light" id="menu-button" title="Menu">
                    <i class="fas fa-ellipsis-v"></i>
                </button>

                <!-- Floating Menu -->
                <div class="floating-menu top-full right-0 mt-2 hidden" id="chat-menu">
                    <div class="menu-item" data-action="new-chat">
                        <i class="fas fa-plus text-accent"></i>
                        <span>New Conversation</span>
                    </div>
                    <div class="menu-item" data-action="search">
                        <i class="fas fa-search text-accent"></i>
                        <span>Search Messages</span>
                    </div>
                    <div class="menu-divider"></div>
                    <div class="menu-item" data-action="maximize">
                        <i class="fas fa-expand text-accent"></i>
                        <span id="maximize-text">Maximize Window</span>
                    </div>
                    <div class="menu-item" data-action="minimize">
                        <i class="fas fa-window-minimize text-accent"></i>
                        <span>Minimize</span>
                    </div>
                    <div class="menu-divider"></div>
                    <div class="menu-item" data-action="toggle-quick-actions">
                        <i class="fas fa-bolt text-accent"></i>
                        <span id="quick-actions-toggle-text">Show Quick Actions</span>
                    </div>
                    <div class="menu-item" data-action="clear-chat">
                        <i class="fas fa-trash-alt text-danger"></i>
                        <span class="text-danger">Clear Chat</span>
                    </div>
                    <div class="menu-item" data-action="close">
                        <i class="fas fa-times text-dark"></i>
                        <span>Close Chat</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions Section - Collapsed by Default -->
    <div class="quick-actions-section collapsed-by-default bg-accent-transparent border-b border-accent/10 transition-all duration-300"
        id="quick-actions-section">
        <!-- Header with Toggle -->
        <div class="px-4 pt-3">
            <div class="flex items-center justify-between">
                <div class="quick-actions-toggle flex items-center gap-2" id="quick-actions-toggle">
                    <i class="fas fa-chevron-down text-accent toggle-icon text-sm"></i>
                    <h4 class="text-sm font-medium text-dark">Quick Actions</h4>
                </div>
                <div class="text-xs text-gray-500">
                    <span id="quick-actions-count">0</span> actions
                </div>
            </div>
        </div>

        <!-- Quick Actions Grid (Full View) - Hidden by default -->
        <div class="px-4 pb-3 quick-actions-grid grid grid-cols-2 gap-3 transition-all duration-300"
            id="quick-actions-grid">
            <!-- Actions will be dynamically added -->
        </div>

        <!-- Quick Actions Bar (Minimized View) - Visible by default -->
        <div class="px-4 pb-3 quick-actions-bar" id="quick-actions-bar">
            <!-- Mini actions will be added here -->
        </div>
    </div>

    <!-- Chat Messages Area -->
    <div class="flex-1 overflow-y-auto bg-light p-4 scrollbar-green" id="chat-messages">
        <!-- Welcome Message -->
        <div class="flex gap-3 mb-4 animate-slide-in-left">
            <div class="user-avatar">
                <i class="fas fa-robot"></i>
            </div>
            <div class="message-bubble bot">
                <div class="text-dark">
                    <p class="font-semibold text-accent">👋 Welcome to Whitebox Assistant</p>
                    <p class="mt-2">I'm here to guide you through:</p>
                    <div class="mt-2 space-y-1">
                        <div class="flex items-center gap-2 text-sm">
                            <div class="w-1.5 h-1.5 bg-accent rounded-full"></div>
                            <span>Application Process & Requirements</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm">
                            <div class="w-1.5 h-1.5 bg-accent rounded-full"></div>
                            <span>Document Submission Guidelines</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm">
                            <div class="w-1.5 h-1.5 bg-accent rounded-full"></div>
                            <span>Entrepreneurship Support</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm">
                            <div class="w-1.5 h-1.5 bg-accent rounded-full"></div>
                            <span>Coaching Program Details</span>
                        </div>
                    </div>
                    <p class="mt-3">What would you like to know about?</p>
                </div>
                <div class="message-time">Just now</div>
            </div>
        </div>
    </div>

    <!-- Typing Indicator -->
    <div class="px-4 py-2 bg-light hidden" id="typing-indicator">
        <div class="flex items-center gap-3">
            <div class="user-avatar">
                <i class="fas fa-robot"></i>
            </div>
            <div class="typing-container">
                <div class="typing-dot w-2 h-2 bg-accent rounded-full"></div>
                <div class="typing-dot w-2 h-2 bg-accent rounded-full" style="animation-delay: 0.2s"></div>
                <div class="typing-dot w-2 h-2 bg-accent rounded-full" style="animation-delay: 0.4s"></div>
            </div>
        </div>
    </div>

    <!-- Input Area -->
    <div class="p-4 border-t border-accent/10 bg-white">
        <div class="flex items-center gap-2">
            <!-- Emoji Button -->
            <button class="action-button text-dark hover:text-accent" id="emoji-button" title="Emoji">
                <i class="far fa-smile text-lg"></i>
            </button>

            <!-- Attachment Button -->
            <button class="action-button text-dark hover:text-accent" id="attachment-button" title="Attach File">
                <i class="fas fa-paperclip text-lg"></i>
            </button>

            <!-- Main Input -->
            <div class="flex-1 relative">
                <textarea id="message-input" class="w-full chat-input py-3 px-4 pr-12 resize-none focus:outline-none"
                    placeholder="Type your message here..." rows="1"></textarea>

                <!-- Character Counter -->
                <div class="absolute right-3 top-3 text-xs text-gray-500" id="char-counter">
                    <span id="char-count">0</span>/500
                </div>
            </div>

            <!-- Send Button -->
            <button
                class="w-10 h-10 rounded-full gradient-accent hover:opacity-90 flex items-center justify-center text-white shadow-md transition-all duration-300 hover:scale-105"
                id="send-button" title="Send">
                <i class="fas fa-paper-plane"></i>
            </button>
        </div>

        <!-- Hint Text -->
        <div class="text-xs text-gray-500 mt-2 text-center">
            Press <kbd class="px-1 py-0.5 bg-gray-100 rounded">Enter</kbd> to send • <kbd
                class="px-1 py-0.5 bg-gray-100 rounded">Shift + Enter</kbd> for new line
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Configuration
        const CONFIG = {
            API_BASE_URL: 'https://whitebox.go.ke/api/chatbot',
            MAX_MESSAGE_LENGTH: 500,
            TYPING_SPEED: 30,
            SESSION_DURATION: 30 * 60 * 1000,
            QUICK_ACTIONS_COLLAPSED: true // Collapsed by default
        };

        // Quick Actions Data
        const QUICK_ACTIONS = [
            {
                icon: 'fas fa-file-alt',
                title: 'Services',
                description: 'View all services',
                query: 'What services does Whitebox offer?',
                color: 'bg-blue-500/10',
                iconColor: 'text-blue-600',
                miniIcon: 'fas fa-file-alt'
            },
            {
                icon: 'fas fa-upload',
                title: 'Documents',
                description: 'Submission guidelines',
                query: 'How do I submit documents?',
                color: 'bg-green-500/10',
                iconColor: 'text-green-600',
                miniIcon: 'fas fa-upload'
            },
            {
                icon: 'fas fa-phone',
                title: 'Contact ICTA',
                description: 'How to reach the ICTA office',
                query: 'How can I contact the ICTA office?', 
                color: 'bg-green-500/10',
                iconColor: 'text-black-600',
                miniIcon: 'fas fa-phone'
            },
            {
                icon: 'fas fa-phone',
                title: 'Contact Whitebox',
                description: 'How to reach the whitebox',
                query: 'How can I contact the whitebox?', 
                color: 'bg-red-500/10',
                iconColor: 'text-red-600',
                miniIcon: 'fas fa-phone'
            },
            {
                icon: 'fas fa-graduation-cap',
                title: 'Coaching',
                description: 'Program details',
                query: 'Tell me about coaching programs',
                color: 'bg-orange-500/10',
                iconColor: 'text-orange-600',
                miniIcon: 'fas fa-graduation-cap'
            }
        ];

        // Elements
        const elements = {
            chatbotIcon: document.getElementById('chatbot-icon'),
            chatbotContainer: document.getElementById('chatbot-container'),
            chatMessages: document.getElementById('chat-messages'),
            messageInput: document.getElementById('message-input'),
            sendButton: document.getElementById('send-button'),
            maximizeButton: document.getElementById('maximize-button'),
            menuButton: document.getElementById('menu-button'),
            chatMenu: document.getElementById('chat-menu'),
            emojiButton: document.getElementById('emoji-button'),
            attachmentButton: document.getElementById('attachment-button'),
            typingIndicator: document.getElementById('typing-indicator'),
            typingText: document.getElementById('typing-text'),
            statusText: document.getElementById('status-text'),
            charCounter: document.getElementById('char-counter'),
            charCount: document.getElementById('char-count'),
            maximizeText: document.getElementById('maximize-text'),
            quickActionsToggle: document.getElementById('quick-actions-toggle'),
            quickActionsSection: document.getElementById('quick-actions-section'),
            quickActionsGrid: document.getElementById('quick-actions-grid'),
            quickActionsBar: document.getElementById('quick-actions-bar'),
            quickActionsCount: document.getElementById('quick-actions-count'),
            quickActionsToggleText: document.getElementById('quick-actions-toggle-text'),
            backToTop: document.getElementById('back-to-top')
        };

        // State
        const state = {
            isChatOpen: false,
            isMaximized: false,
            isMinimized: false,
            isTyping: false,
            sessionId: null,
            currentMenu: null,
            quickActionsMinimized: CONFIG.QUICK_ACTIONS_COLLAPSED, // Collapsed by default
            quickActionsHidden: false
        };

        // Initialize
        function init() {
            setupSession();
            setupQuickActions();
            setupEventListeners();
            setupMenu();
            checkConnection();
            setupAutoHideBackToTop();

            // Load quick actions state from localStorage (overrides default)
            loadQuickActionsState();
        }

        // Load quick actions state
        function loadQuickActionsState() {
            const savedState = localStorage.getItem('wb_quick_actions_state');
            if (savedState) {
                const data = JSON.parse(savedState);
                state.quickActionsMinimized = data.minimized !== undefined ? data.minimized : CONFIG.QUICK_ACTIONS_COLLAPSED;
                state.quickActionsHidden = data.hidden || false;

                // Apply loaded state
                if (state.quickActionsHidden) {
                    hideQuickActions();
                } else if (!state.quickActionsMinimized) {
                    expandQuickActions();
                }
            } else {
                // Apply default collapsed state
                if (state.quickActionsMinimized) {
                    collapseQuickActions();
                }
            }
        }

        // Save quick actions state
        function saveQuickActionsState() {
            localStorage.setItem('wb_quick_actions_state', JSON.stringify({
                minimized: state.quickActionsMinimized,
                hidden: state.quickActionsHidden
            }));
        }

        // Collapse quick actions (apply collapsed state)
        function collapseQuickActions() {
            elements.quickActionsSection.classList.add('collapsed-by-default');
            elements.quickActionsBar.classList.remove('hidden');
            elements.quickActionsGrid.classList.add('hidden');
            if (elements.quickActionsToggleText) {
                elements.quickActionsToggleText.textContent = 'Show Quick Actions';
            }
            state.quickActionsMinimized = true;
        }

        // Expand quick actions (apply expanded state)
        function expandQuickActions() {
            elements.quickActionsSection.classList.remove('collapsed-by-default');
            elements.quickActionsBar.classList.add('hidden');
            elements.quickActionsGrid.classList.remove('hidden');
            if (elements.quickActionsToggleText) {
                elements.quickActionsToggleText.textContent = 'Hide Quick Actions';
            }
            state.quickActionsMinimized = false;
        }

        // Hide quick actions completely
        function hideQuickActions() {
            elements.quickActionsSection.classList.add('hidden');
            if (elements.quickActionsToggleText) {
                elements.quickActionsToggleText.textContent = 'Show Quick Actions';
            }
            state.quickActionsHidden = true;
            state.quickActionsMinimized = true;
        }

        // Show quick actions
        function showQuickActions() {
            elements.quickActionsSection.classList.remove('hidden');
            if (elements.quickActionsToggleText) {
                elements.quickActionsToggleText.textContent = 'Hide Quick Actions';
            }
            state.quickActionsHidden = false;
        }

        // Setup session
        function setupSession() {
            const savedSession = localStorage.getItem('wb_chat_session_v4');
            if (savedSession) {
                const data = JSON.parse(savedSession);
                if (Date.now() - data.created < CONFIG.SESSION_DURATION) {
                    state.sessionId = data.id;
                    return;
                }
            }

            state.sessionId = 'wb_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
            localStorage.setItem('wb_chat_session_v4', JSON.stringify({
                id: state.sessionId,
                created: Date.now()
            }));
        }

        // Setup quick actions
        function setupQuickActions() {
            // Setup full grid view
            setupQuickActionsGrid();

            // Setup mini bar view
            setupQuickActionsBar();

            // Update count
            elements.quickActionsCount.textContent = QUICK_ACTIONS.length;
        }

        // Setup quick actions grid
        function setupQuickActionsGrid() {
            elements.quickActionsGrid.innerHTML = '';

            QUICK_ACTIONS.forEach((action, index) => {
                const actionElement = createQuickActionCard(action, index);
                elements.quickActionsGrid.appendChild(actionElement);
            });
        }

        // Setup quick actions bar
        function setupQuickActionsBar() {
            elements.quickActionsBar.innerHTML = '';

            QUICK_ACTIONS.forEach(action => {
                const miniAction = document.createElement('div');
                miniAction.className = 'quick-action-mini';
                miniAction.innerHTML = `
                    <i class="${action.miniIcon} ${action.iconColor}"></i>
                    <span>${action.title}</span>
                `;

                miniAction.addEventListener('click', () => {
                    sendQuickAction(action.query);
                    highlightMiniAction(miniAction);
                });

                elements.quickActionsBar.appendChild(miniAction);
            });
        }

        // Create quick action card
        function createQuickActionCard(action, index) {
            const actionElement = document.createElement('div');
            actionElement.className = 'quick-action-card';
            actionElement.style.animationDelay = `${index * 0.1}s`;
            actionElement.innerHTML = `
                <div class="icon-wrapper ${action.color}">
                    <i class="${action.icon} ${action.iconColor}"></i>
                </div>
                <div>
                    <div class="font-medium text-dark text-sm">${action.title}</div>
                    <div class="text-xs text-gray-500 mt-1">${action.description}</div>
                </div>
            `;

            actionElement.addEventListener('click', () => {
                sendQuickAction(action.query);
                highlightAction(actionElement);
            });

            return actionElement;
        }

        // Setup event listeners
        function setupEventListeners() {
            // Chat toggle
            elements.chatbotIcon.addEventListener('click', toggleChat);

            // Menu toggle
            elements.menuButton.addEventListener('click', toggleMenu);
            document.addEventListener('click', closeMenuOnClickOutside);

            // Maximize button
            elements.maximizeButton.addEventListener('click', toggleMaximize);

            // Quick actions toggle
            elements.quickActionsToggle.addEventListener('click', toggleQuickActionsView);

            // Message input
            elements.messageInput.addEventListener('input', handleInput);
            elements.messageInput.addEventListener('keydown', handleKeyDown);
            elements.sendButton.addEventListener('click', sendMessage);

            // Attachment button (placeholder)
            elements.attachmentButton.addEventListener('click', () => {
                showNotification('📎 File attachment feature coming soon!', 'info');
            });

            // Emoji button (placeholder)
            elements.emojiButton.addEventListener('click', () => {
                showNotification('😊 Emoji picker coming soon!', 'info');
            });

            // Prevent chat container clicks from closing
            elements.chatbotContainer.addEventListener('click', (e) => e.stopPropagation());
        }

        // Setup menu actions
        function setupMenu() {
            const menuItems = document.querySelectorAll('.menu-item');
            menuItems.forEach(item => {
                item.addEventListener('click', () => {
                    const action = item.getAttribute('data-action');
                    handleMenuAction(action);
                    closeMenu();
                });
            });
        }

        // Handle menu actions
        function handleMenuAction(action) {
            switch (action) {
                case 'new-chat':
                    clearChat();
                    showNotification('🔄 New conversation started', 'success');
                    break;

                case 'search':
                    showNotification('🔍 Search functionality coming soon!', 'info');
                    break;

                case 'maximize':
                    toggleMaximize();
                    break;

                case 'minimize':
                    toggleMinimize();
                    break;

                case 'toggle-quick-actions':
                    toggleQuickActionsVisibility();
                    break;

                case 'clear-chat':
                    if (confirm('Clear all chat messages?')) {
                        clearChat();
                        showNotification('🗑️ Chat cleared', 'success');
                    }
                    break;

                case 'close':
                    toggleChat();
                    break;
            }
        }

        // Toggle quick actions view (collapsed/expanded)
        function toggleQuickActionsView() {
            if (state.quickActionsMinimized) {
                expandQuickActions();
                showNotification('📋 Quick actions expanded', 'info');
            } else {
                collapseQuickActions();
                showNotification('📱 Quick actions collapsed', 'info');
            }

            saveQuickActionsState();
        }

        // Toggle quick actions visibility (show/hide)
        function toggleQuickActionsVisibility() {
            if (state.quickActionsHidden) {
                showQuickActions();
                showNotification('👁️ Quick actions visible', 'info');
            } else {
                hideQuickActions();
                showNotification('👁️ Quick actions hidden', 'info');
            }

            saveQuickActionsState();
        }

        // Toggle chat visibility
        function toggleChat() {
            state.isChatOpen = !state.isChatOpen;

            if (state.isChatOpen) {
                // Open chat
                elements.chatbotContainer.classList.remove('opacity-0', 'translate-y-5', 'pointer-events-none');
                elements.chatbotContainer.classList.add('opacity-100', 'translate-y-0', 'pointer-events-auto');
                elements.messageInput.focus();

                // Reset to normal size if minimized
                if (state.isMinimized) {
                    toggleMinimize();
                }

                showNotification('✅ Connected to Whitebox Assistant', 'success');
            } else {
                // Close chat
                elements.chatbotContainer.classList.remove('opacity-100', 'translate-y-0', 'pointer-events-auto');
                elements.chatbotContainer.classList.add('opacity-0', 'translate-y-5', 'pointer-events-none');

                // Close any open menus
                closeMenu();
            }
        }

        // Toggle maximize
        function toggleMaximize() {
            state.isMaximized = !state.isMaximized;

            if (state.isMaximized) {
                elements.chatbotContainer.classList.remove('chat-normal');
                elements.chatbotContainer.classList.add('chat-maximized');
                elements.maximizeText.textContent = 'Restore Window';
                elements.maximizeButton.innerHTML = '<i class="fas fa-compress text-sm"></i>';
                showNotification('🔲 Chat maximized', 'info');
            } else {
                elements.chatbotContainer.classList.remove('chat-maximized');
                elements.chatbotContainer.classList.add('chat-normal');
                elements.maximizeText.textContent = 'Maximize Window';
                elements.maximizeButton.innerHTML = '<i class="fas fa-expand text-sm"></i>';
            }

            // Scroll to bottom after resize
            setTimeout(scrollToBottom, 100);
        }

        // Toggle minimize
        function toggleMinimize() {
            state.isMinimized = !state.isMinimized;

            if (state.isMinimized) {
                elements.chatbotContainer.classList.remove('chat-normal');
                elements.chatbotContainer.classList.add('chat-minimized');
                showNotification('📱 Chat minimized', 'info');
            } else {
                elements.chatbotContainer.classList.remove('chat-minimized');
                elements.chatbotContainer.classList.add('chat-normal');
            }
        }

        // Toggle menu
        function toggleMenu() {
            elements.chatMenu.classList.toggle('hidden');
            state.currentMenu = state.currentMenu === 'main' ? null : 'main';
        }

        // Close menu
        function closeMenu() {
            elements.chatMenu.classList.add('hidden');
            state.currentMenu = null;
        }

        // Close menu on click outside
        function closeMenuOnClickOutside(e) {
            if (!elements.menuButton.contains(e.target) && !elements.chatMenu.contains(e.target)) {
                closeMenu();
            }
        }

        // Handle input
        function handleInput() {
            const count = elements.messageInput.value.length;
            elements.charCount.textContent = count;

            // Change color if near limit
            if (count > CONFIG.MAX_MESSAGE_LENGTH * 0.9) {
                elements.charCount.classList.add('text-danger');
            } else {
                elements.charCount.classList.remove('text-danger');
            }

            // Auto-resize textarea
            elements.messageInput.style.height = 'auto';
            elements.messageInput.style.height = Math.min(elements.messageInput.scrollHeight, 120) + 'px';
        }

        // Handle key down
        function handleKeyDown(e) {
            // Enter to send (unless Shift is held)
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                sendMessage();
            }
        }

        // Show notification
        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            const bgColor = type === 'success' ? 'bg-accent' :
                type === 'error' ? 'bg-danger' :
                    type === 'info' ? 'bg-dark' : 'bg-dark';

            notification.className = `fixed top-4 right-4 px-4 py-3 rounded-lg shadow-lg z-50 animate-slide-in-right ${bgColor} text-white flex items-center gap-2`;
            notification.innerHTML = `
                ${message}
                <button class="ml-2 text-white/80 hover:text-white" onclick="this.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            `;

            document.body.appendChild(notification);

            setTimeout(() => {
                notification.classList.add('opacity-0', 'translate-x-10');
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }

        // Check connection
        async function checkConnection() {
            try {
                const response = await fetch(`${CONFIG.API_BASE_URL}/health`);
                if (response.ok) {
                    elements.statusText.textContent = 'Online';
                } else {
                    throw new Error('API not healthy');
                }
            } catch (error) {
                elements.statusText.textContent = 'Offline';
                console.warn('Connection check failed:', error);
            }
        }

        // Clear chat
        function clearChat() {
            while (elements.chatMessages.children.length > 1) {
                elements.chatMessages.removeChild(elements.chatMessages.lastChild);
            }

            // Add new welcome message
            setTimeout(() => {
                addMessage("Hello! How can I assist you today?", false);
            }, 300);
        }

        // Add message to chat
        function addMessage(content, isUser = true) {
            const messageDiv = document.createElement('div');
            messageDiv.className = `flex gap-3 mb-4 ${isUser ? 'justify-end' : 'animate-slide-in-left'}`;

            if (!isUser) {
                messageDiv.innerHTML = `
                    <div class="user-avatar">
                        <i class="fas fa-robot"></i>
                    </div>
                `;
            }

            const messageContent = document.createElement('div');
            messageContent.className = `message-bubble ${isUser ? 'user' : 'bot'}`;

            const textDiv = document.createElement('div');
            textDiv.className = isUser ? 'text-white' : 'text-dark';
            textDiv.innerHTML = formatMessage(content);
            messageContent.appendChild(textDiv);

            const timeDiv = document.createElement('div');
            timeDiv.className = 'message-time';
            timeDiv.style.color = isUser ? 'rgba(255,255,255,0.7)' : 'rgba(0,0,0,0.5)';
            timeDiv.textContent = getCurrentTime();
            messageContent.appendChild(timeDiv);

            if (isUser) {
                messageDiv.appendChild(messageContent);
            } else {
                const avatar = messageDiv.firstChild;
                messageDiv.appendChild(messageContent);
                messageDiv.insertBefore(avatar, messageContent);
            }

            elements.chatMessages.appendChild(messageDiv);
            scrollToBottom();
        }

        // Format message
        function formatMessage(text) {
            return text
                .replace(/\*\*(.*?)\*\*/g, '<strong class="font-semibold">$1</strong>')
                .replace(/\*(.*?)\*/g, '<em>$1</em>')
                .replace(/\n/g, '<br>');
        }

        // Get current time
        function getCurrentTime() {
            const now = new Date();
            return now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        }

        // Show typing indicator
        function showTypingIndicator() {
            if (state.isTyping || state.isMinimized) return;

            state.isTyping = true;
            elements.typingIndicator.classList.remove('hidden');
            elements.typingText.classList.remove('hidden');
            scrollToBottom();
        }

        // Hide typing indicator
        function hideTypingIndicator() {
            state.isTyping = false;
            elements.typingIndicator.classList.add('hidden');
            elements.typingText.classList.add('hidden');
        }

        // Scroll to bottom
        function scrollToBottom() {
            setTimeout(() => {
                elements.chatMessages.scrollTop = elements.chatMessages.scrollHeight;
            }, 100);
        }

        // Send quick action
        function sendQuickAction(query) {
            elements.messageInput.value = query;
            sendMessage();
        }

        // Highlight action card
        function highlightAction(element) {
            element.classList.add('ring-2', 'ring-accent');
            setTimeout(() => {
                element.classList.remove('ring-2', 'ring-accent');
            }, 1000);
        }

        // Highlight mini action
        function highlightMiniAction(element) {
            element.classList.add('bg-accent-transparent', 'ring-1', 'ring-accent');
            setTimeout(() => {
                element.classList.remove('bg-accent-transparent', 'ring-1', 'ring-accent');
            }, 1000);
        }

        // Send message
        async function sendMessage() {
            const message = elements.messageInput.value.trim();

            if (!message) {
                elements.messageInput.focus();
                return;
            }

            if (message.length > CONFIG.MAX_MESSAGE_LENGTH) {
                showNotification(`Message too long (max ${CONFIG.MAX_MESSAGE_LENGTH} characters)`, 'error');
                return;
            }

            // Add user message
            addMessage(message, true);

            // Clear input
            elements.messageInput.value = '';
            elements.messageInput.style.height = 'auto';
            elements.charCount.textContent = '0';
            elements.charCount.classList.remove('text-danger');

            // Send to API
            await sendToAPI(message);
        }

        // Send to API with typing animation
        async function sendToAPI(message) {
            showTypingIndicator();

            try {
                const response = await fetch(`${CONFIG.API_BASE_URL}/chat`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        question: message,
                        session_id: state.sessionId
                    })
                });

                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}`);
                }

                const data = await response.json();

                // Simulate typing delay
                await new Promise(resolve => setTimeout(resolve, 1000));
                hideTypingIndicator();

                if (data.answer) {
                    // Type out the response
                    await typeMessage(data.answer);
                } else {
                    addMessage("I received your message but didn't get a proper response. Please try again.", false);
                }
            } catch (error) {
                console.error('API Error:', error);
                hideTypingIndicator();

                await typeMessage("I'm having trouble connecting right now. Please try again in a moment.");

                // Update status
                elements.statusText.textContent = 'Offline';
            }
        }

        // Type message with animation
        async function typeMessage(message) {
            hideTypingIndicator();

            // Create message container
            const messageDiv = document.createElement('div');
            messageDiv.className = 'flex gap-3 mb-4 animate-slide-in-left';
            messageDiv.innerHTML = `
                <div class="user-avatar">
                    <i class="fas fa-robot"></i>
                </div>
                <div class="message-bubble bot">
                    <div class="text-dark message-content"></div>
                    <div class="message-time">${getCurrentTime()}</div>
                </div>
            `;

            elements.chatMessages.appendChild(messageDiv);
            const contentDiv = messageDiv.querySelector('.message-content');

            // Type out message character by character
            for (let i = 0; i < message.length; i++) {
                contentDiv.innerHTML = formatMessage(message.substring(0, i + 1));
                scrollToBottom();
                await new Promise(resolve => setTimeout(resolve, CONFIG.TYPING_SPEED));
            }
        }

        // Setup auto-hide back to top button
        function setupAutoHideBackToTop() {
            window.addEventListener('scroll', () => {
                if (window.scrollY > 300) {
                    elements.backToTop.classList.remove('opacity-0', 'invisible');
                } else {
                    elements.backToTop.classList.add('opacity-0', 'invisible');
                }
            });
        }

        // Initialize
        init();

        // Periodic connection check
        setInterval(checkConnection, 60000);
    });
</script>