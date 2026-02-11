 <!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1" />
    <title>OFLeaks.tv &mdash; Home</title>

    <!-- Pagination Scroll-Fix - MUSS ganz am Anfang sein -->
    <script>
    if (sessionStorage.getItem('scrollTop') === '1') {
        sessionStorage.removeItem('scrollTop');
        if ('scrollRestoration' in history) history.scrollRestoration = 'manual';
        // Mehrfach versuchen um Browser-Restore zu überschreiben
        window.scrollTo(0, 0);
        document.addEventListener('DOMContentLoaded', function() { window.scrollTo(0, 0); });
        window.addEventListener('load', function() { window.scrollTo(0, 0); });
    }
    </script>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="./assets/vendor/toastify/toastify.min.css" />
    <script src="./assets/vendor/jquery/jquery.min.js"></script>
    <script src="./assets/vendor/fontawesome/3dc1b48f3d.js"></script>
    <link rel="stylesheet" href="./assets/vendor/sweetalert/borderless.min.css" />
    <script src="./assets/vendor/sweetalert/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="./assets/vendor/fancybox/fancybox.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lozad.js/1.0.8/lozad.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background-color: #0a0a0a;
            color: #ffffff;
            overflow-x: hidden;
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            height: 100dvh; /* Dynamic viewport height für iOS */
            width: 280px;
            background: rgba(18, 18, 18, 0.95);
            backdrop-filter: blur(10px);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            z-index: 1000;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow-y: auto;
            overflow-x: hidden;
            -webkit-overflow-scrolling: touch; /* Smooth scroll auf iOS */
            overscroll-behavior: contain; /* Verhindert Scroll-Bleeding zur Hauptseite */
        }

        .sidebar.collapsed {
            transform: translateX(-220px);
        }

        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }

        .sidebar-toggle {
            position: fixed;
            left: 280px;
            top: 20px;
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, rgba(230, 56, 181, 0.9), rgba(147, 51, 234, 0.9));
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 0 12px 12px 0;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 1001;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(230, 56, 181, 0.4), 0 0 20px rgba(230, 56, 181, 0.2);
        }

        .sidebar.collapsed + .sidebar-toggle {
            left: 60px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(230, 56, 181, 0.5), 0 0 25px rgba(230, 56, 181, 0.3);
        }

        .sidebar-toggle:hover {
            background: linear-gradient(135deg, rgba(230, 56, 181, 1), rgba(147, 51, 234, 1));
            transform: scale(1.05);
            box-shadow: 0 6px 16px rgba(230, 56, 181, 0.6), 0 0 30px rgba(230, 56, 181, 0.4);
        }
        
        .sidebar-toggle i {
            font-size: 16px;
            color: white;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        /* Main Content */
        .main-content {
            margin-left: 280px;
            min-height: 100vh;
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            padding: 20px;
        }

        .sidebar.collapsed ~ .main-content {
            margin-left: 60px;
        }

        /* Logo */
        .sidebar-logo {
            padding: 24px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            transition: all 0.3s ease;
        }

        .logo-circle {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #ff007f, #a145ff);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            position: relative;
            box-shadow: 0 3px 10px rgba(255, 0, 127, 0.4);
        }

        .premium-indicator {
            position: absolute;
            top: -8px;
            right: -8px;
            background: linear-gradient(135deg, #ff007f, #a145ff);
            color: white;
            font-size: 10px;
            padding: 2px 6px;
            border-radius: 10px;
            font-weight: 700;
            box-shadow: 0 2px 4px rgba(0,0,0,0.3);
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        @keyframes pulse-shadow {
            0% { box-shadow: 0 0 0 0 rgba(255, 0, 127, 0.5); }
            70% { box-shadow: 0 0 0 10px rgba(255, 0, 127, 0); }
            100% { box-shadow: 0 0 0 0 rgba(255, 0, 127, 0); }
        }

        .logo-icon {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo-text {
            overflow: hidden;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .sidebar.collapsed .logo-text {
            opacity: 0;
            width: 0;
        }

        /* Nav Items */
        .nav-section {
            padding: 16px 12px;
        }

        .nav-section-title {
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.4);
            padding: 0 12px 8px;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }

        .sidebar.collapsed .nav-section-title {
            opacity: 0;
            height: 0;
            padding: 0;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            margin: 4px 0;
            border-radius: 12px;
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: all 0.2s ease;
            cursor: pointer;
            position: relative;
        }

        .nav-item:hover {
            background: rgba(255, 255, 255, 0.05);
            color: white;
        }

        .nav-item.active {
            background: rgba(230, 56, 181, 0.15);
            color: #E638B5;
            font-weight: 600;
        }

        .nav-item.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 24px;
            background: #E638B5;
            border-radius: 0 4px 4px 0;
        }

        /* Kostenlos Zugang Link - Minimaler Glow Effekt */
        .nav-item-free-access {
            background: rgba(230, 56, 181, 0.08);
            border: 1px solid rgba(230, 56, 181, 0.2);
            box-shadow: 0 0 12px rgba(230, 56, 181, 0.15), 0 0 6px rgba(147, 51, 234, 0.1);
        }

        .nav-item-free-access:hover {
            background: rgba(230, 56, 181, 0.12);
            box-shadow: 0 0 16px rgba(230, 56, 181, 0.25), 0 0 8px rgba(147, 51, 234, 0.15);
            border-color: rgba(230, 56, 181, 0.3);
        }

        .nav-item-icon {
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 18px;
        }

        .nav-item-text {
            white-space: nowrap;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .sidebar.collapsed .nav-item-text {
            opacity: 0;
            width: 0;
        }

        .sidebar.collapsed .nav-item {
            justify-content: center;
            padding: 12px;
        }

        /* Submenu */
        .nav-item-submenu {
            display: none;
            padding-left: 28px;
            margin-top: 4px;
        }

        .nav-item-submenu.active {
            display: block !important;
        }

        .sidebar.collapsed .nav-item-submenu {
            display: none !important;
        }

        .nav-item-chevron {
            margin-left: auto;
            transition: transform 0.2s ease;
            flex-shrink: 0;
        }

        .nav-item.expanded .nav-item-chevron {
            transform: rotate(90deg);
        }

        .nav-item.expanded .nav-item-chevron i {
            transform: rotate(90deg);
        }

        .sidebar.collapsed .nav-item-chevron {
            display: none;
        }

        /* Online Counter */
        .online-counter {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 12px 16px;
            margin: 12px;
            background: rgba(74, 222, 128, 0.1);
            border: 1px solid rgba(74, 222, 128, 0.2);
            border-radius: 12px;
            font-size: 14px;
        }

        .online-dot {
            width: 8px;
            height: 8px;
            background: #4ade80;
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        @keyframes gradient-shift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        @keyframes pulse-glow {
            0%, 100% {
                opacity: 1;
                box-shadow: 0 0 10px rgba(139, 92, 246, 0.5);
            }
            50% {
                opacity: 0.8;
                box-shadow: 0 0 20px rgba(236, 72, 153, 0.8);
            }
        }

        .sidebar.collapsed .online-counter {
            flex-direction: column;
            gap: 4px;
            padding: 8px;
        }

        .sidebar.collapsed .online-counter span {
            display: none;
        }

        /* Mobile - Complete Rework */
        @media (max-width: 768px) {
            /* Sidebar Base */
            .sidebar {
                position: fixed;
                left: 0;
                top: 0;
                height: 100vh;
                height: 100dvh; /* Dynamic viewport height für iOS Safari */
                height: -webkit-fill-available; /* Fallback für ältere iOS */
                width: 280px;
                transform: translateX(-280px);
                transition: transform 0.3s ease;
                z-index: 1000;
                overflow-y: auto;
                -webkit-overflow-scrolling: touch; /* Smooth scroll auf iOS */
                overscroll-behavior: contain; /* Verhindert Scroll-Bleeding zur Hauptseite */
                background: rgba(18, 18, 18, 0.98);
                backdrop-filter: blur(10px);
                padding-bottom: env(safe-area-inset-bottom, 20px); /* Safe area für iPhone mit Home-Indicator */
            }

            .sidebar.mobile-open {
                transform: translateX(0) !important;
            }

            .sidebar:not(.mobile-open) {
                transform: translateX(-280px) !important;
            }

            /* Force show all content - override collapsed state */
            .sidebar.mobile-open,
            .sidebar.mobile-open.collapsed {
                width: 280px !important;
                transform: translateX(0) !important;
            }

            .sidebar.mobile-open .logo-text,
            .sidebar.mobile-open.collapsed .logo-text {
                opacity: 1 !important;
                width: auto !important;
                display: flex !important;
            }

            .sidebar.mobile-open .logo-icon,
            .sidebar.mobile-open.collapsed .logo-icon {
                display: flex !important;
            }

            .sidebar.mobile-open .nav-item-text,
            .sidebar.mobile-open.collapsed .nav-item-text {
                opacity: 1 !important;
                width: auto !important;
                display: block !important;
            }

            .sidebar.mobile-open .nav-section-title,
            .sidebar.mobile-open.collapsed .nav-section-title {
                opacity: 1 !important;
                height: auto !important;
                padding: 0 12px 8px !important;
                display: block !important;
            }

            .sidebar.mobile-open .nav-item,
            .sidebar.mobile-open.collapsed .nav-item {
                justify-content: flex-start !important;
                padding: 12px 16px !important;
                gap: 12px !important;
            }

            .sidebar.mobile-open .nav-item-chevron,
            .sidebar.mobile-open.collapsed .nav-item-chevron {
                display: flex !important;
                margin-left: auto !important;
                opacity: 1 !important;
            }

            .sidebar.mobile-open .nav-item-submenu,
            .sidebar.mobile-open.collapsed .nav-item-submenu {
                display: none;
                padding-left: 0 !important;
            }

            .sidebar.mobile-open .nav-item-submenu.active,
            .sidebar.mobile-open.collapsed .nav-item-submenu.active {
                display: block !important;
            }

            .sidebar.mobile-open .nav-item-submenu .nav-item,
            .sidebar.mobile-open.collapsed .nav-item-submenu .nav-item {
                padding: 10px 16px 10px 40px !important;
                font-size: 14px !important;
            }

            .sidebar.mobile-open .online-counter,
            .sidebar.mobile-open.collapsed .online-counter {
                display: flex !important;
                flex-direction: row !important;
                gap: 8px !important;
                padding: 12px 16px !important;
            }

            .sidebar.mobile-open .online-counter span,
            .sidebar.mobile-open.collapsed .online-counter span {
                display: inline !important;
            }

            /* Hide desktop toggle button */
            .sidebar-toggle {
                display: none !important;
            }

            /* Main content no margin on mobile */
            .main-content {
                margin-left: 0 !important;
            }

            /* Mobile overlay */
            .mobile-overlay {
                display: none;
                position: fixed;
                inset: 0;
                background: rgba(0, 0, 0, 0.75);
                z-index: 999;
                backdrop-filter: blur(3px);
            }

            .mobile-overlay.active {
                display: block;
            }

            /* Clean spacing */
            .sidebar-logo {
                padding: 24px 20px;
                gap: 12px;
            }

            .search-container {
                padding: 16px 20px;
            }

            .nav-section {
                padding: 16px 12px;
            }

            .nav-item {
                margin: 2px 0;
            }

            .nav-section-title {
                font-size: 11px;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }
        }

        /* Top Bar Mobile */
        .top-bar-mobile {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 60px;
            background: rgba(18, 18, 18, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            z-index: 998;
            padding: 0 20px;
            align-items: center;
            justify-content: space-between;
        }

        @media (max-width: 768px) {
            .top-bar-mobile {
                display: flex;
            }

            .main-content {
                padding-top: 80px;
            }
        }

        /* Category Pills */
        .category-pills {
            display: flex;
            gap: 8px;
            overflow-x: auto;
            padding: 16px 0;
            scrollbar-width: none;
        }

        .category-pills::-webkit-scrollbar {
            display: none;
        }

        .category-pill {
            padding: 8px 16px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            white-space: nowrap;
            cursor: pointer;
            transition: all 0.2s ease;
            font-size: 14px;
        }

        .category-pill:hover {
            background: rgba(255, 255, 255, 0.08);
        }

        .category-pill.active {
            background: rgba(230, 56, 181, 0.15);
            border-color: rgba(230, 56, 181, 0.3);
            color: #E638B5;
        }

        /* Search */
        .search-container {
            padding: 16px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .search-input {
            width: 100%;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 12px 16px 12px 40px;
            color: white;
            font-size: 14px;
            outline: none;
            transition: all 0.2s ease;
        }

        .search-input:focus {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(230, 56, 181, 0.3);
        }

        .search-icon {
            position: absolute;
            left: 32px;
            top: 28px;
            color: rgba(255, 255, 255, 0.4);
        }

        /* Notification Bell Styles */
        .notification-bell-container {
            position: relative;
            display: inline-flex;
            align-items: center;
            margin-left: auto;
        }

        .notification-bell {
            position: relative;
            cursor: pointer;
            padding: 8px;
            border-radius: 8px;
            transition: all 0.2s ease;
            color: rgba(255, 255, 255, 0.7);
        }

        .notification-bell:hover {
            background: rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 1);
        }

        .notification-badge {
            position: absolute;
            top: 4px;
            right: 4px;
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            font-size: 10px;
            font-weight: bold;
            padding: 2px 5px;
            border-radius: 10px;
            min-width: 18px;
            text-align: center;
            line-height: 1.2;
            box-shadow: 0 2px 4px rgba(239, 68, 68, 0.5);
            animation: pulse-badge 2s ease-in-out infinite;
        }

        @keyframes pulse-badge {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        .notification-dropdown {
            position: absolute;
            top: 100%;
            margin-top: 8px;
            width: 380px;
            max-width: calc(100vw - 40px);
            background: rgba(18, 18, 18, 0.98);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
            z-index: 10000;
            display: none;
            overflow: hidden;
        }

        /* Desktop: Öffne nach rechts (außerhalb der Sidebar) */
        .sidebar .notification-bell-container .notification-dropdown.show {
            position: fixed !important;
            z-index: 10001 !important;
            display: block !important;
        }

        /* Mobile: Öffne nach links (oben rechts im Viewport) */
        .mobile-notification-bell .notification-dropdown {
            right: 0;
            left: auto;
        }

        .notification-dropdown.show {
            display: block !important;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .notification-header {
            padding: 16px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .notification-header h3 {
            font-size: 16px;
            font-weight: 600;
            color: white;
            margin: 0;
        }

        .notification-mark-all {
            background: none;
            border: none;
            color: rgba(230, 56, 181, 0.8);
            font-size: 12px;
            cursor: pointer;
            padding: 4px 8px;
            border-radius: 6px;
            transition: all 0.2s ease;
        }

        .notification-mark-all:hover {
            background: rgba(230, 56, 181, 0.1);
            color: #E638B5;
        }

        .notification-header-actions {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .notification-delete-all {
            background: none;
            border: none;
            color: rgba(239, 68, 68, 0.8);
            font-size: 12px;
            cursor: pointer;
            padding: 4px 8px;
            border-radius: 6px;
            transition: all 0.2s ease;
        }

        .notification-delete-all:hover {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
        }

        .notification-list {
            max-height: 400px;
            overflow-y: auto;
        }

        .notification-list::-webkit-scrollbar {
            width: 6px;
        }

        .notification-list::-webkit-scrollbar-track {
            background: transparent;
        }

        .notification-list::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }

        .notification-item {
            padding: 12px 16px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            gap: 12px;
            position: relative;
        }

        .notification-item:hover {
            background: rgba(255, 255, 255, 0.05);
        }

        .notification-item.unread {
            background: rgba(230, 56, 181, 0.05);
        }

        .notification-item.unread:hover {
            background: rgba(230, 56, 181, 0.1);
        }

        .notification-item-actions {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            display: flex;
            gap: 8px;
            opacity: 0;
            transition: opacity 0.2s ease;
        }

        .notification-item:hover .notification-item-actions {
            opacity: 1;
        }

        .notification-action-btn {
            width: 28px;
            height: 28px;
            border-radius: 6px;
            border: none;
            background: rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.7);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            font-size: 12px;
        }

        .notification-action-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }

        .notification-action-btn.mark-read {
            color: rgba(34, 197, 94, 0.8);
        }

        .notification-action-btn.mark-read:hover {
            background: rgba(34, 197, 94, 0.2);
            color: #22c55e;
        }

        .notification-action-btn.delete {
            color: rgba(239, 68, 68, 0.8);
        }

        .notification-action-btn.delete:hover {
            background: rgba(239, 68, 68, 0.2);
            color: #ef4444;
        }

        .notification-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            background: linear-gradient(135deg, rgba(230, 56, 181, 0.2), rgba(147, 51, 234, 0.2));
        }

        .notification-content {
            flex: 1;
            min-width: 0;
        }

        .notification-title {
            font-size: 14px;
            font-weight: 600;
            color: white;
            margin-bottom: 4px;
        }

        .notification-message {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.6);
            line-height: 1.4;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .notification-time {
            font-size: 11px;
            color: rgba(255, 255, 255, 0.4);
            margin-top: 4px;
        }

        .notification-empty {
            padding: 40px 20px;
            text-align: center;
            color: rgba(255, 255, 255, 0.5);
        }

        .notification-empty i {
            font-size: 48px;
            margin-bottom: 12px;
            opacity: 0.3;
        }

        /* Mobile Notification Bell */
        .mobile-notification-bell {
            position: relative;
            margin-right: 12px;
        }

        .mobile-notification-bell .notification-bell {
            color: white;
        }
    </style>
</head>
<body>
    
    <!-- Mobile Overlay -->
    <div class="mobile-overlay" id="mobileOverlay"></div>

    <!-- Mobile Top Bar -->
    <div class="top-bar-mobile">
        <div class="flex items-center gap-3">
            <button id="mobileSidebarToggle" class="text-white">
                <i class="fas fa-bars text-xl"></i>
            </button>
            <div class="logo-circle">
                <span style="color: white; font-weight: 900; font-size: 16px;">OF</span>
            </div>
            <span style="font-size: 1.2rem; font-weight: 800; background: linear-gradient(90deg, #E638B5, #9333EA); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">OFLeaks.tv</span>
        </div>
        <div class="flex items-center gap-2">
            <div class="mobile-notification-bell notification-bell-container">
                <div class="notification-bell" onclick="toggleNotificationDropdown(event)">
                    <i class="fas fa-bell text-xl"></i>
                    <span class="notification-badge" id="mobileNotificationBadge" style="display: none;">0</span>
                </div>
                <div class="notification-dropdown" id="mobileNotificationDropdown">
                    <div class="notification-header">
                        <h3>Benachrichtigungen</h3>
                        <div class="notification-header-actions">
                            <button class="notification-mark-all" onclick="markAllNotificationsAsRead()">Alle als gelesen</button>
                            <button class="notification-delete-all" onclick="deleteAllNotifications()">Alle löschen</button>
                        </div>
                    </div>
                    <div class="notification-list" id="mobileNotificationList">
                        <div class="notification-empty">
                            <i class="fas fa-bell-slash"></i>
                            <p>Keine Benachrichtigungen</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <nav class="sidebar" id="sidebar">
        <!-- Logo -->
        <a href="/home" class="sidebar-logo" style="text-decoration: none;">
            <div class="logo-icon">
                <div class="logo-circle" style="animation: pulse-shadow 2s infinite;">
                    <span style="color: white; font-weight: 900; font-size: 18px; letter-spacing: -1px;">OF</span>
                    <span class="premium-indicator">VIP</span>
                </div>
            </div>
            <div class="logo-text">
                <span style="font-size: 1.7rem; font-weight: 900; line-height: 1; background: linear-gradient(90deg, #ff007f, #a145ff); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent; letter-spacing: -0.5px; filter: drop-shadow(0 2px 3px rgba(255, 0, 127, 0.3));">
                    OFLeaks<span style="color: white; -webkit-text-fill-color: white;">.tv</span>
                </span>
                <span style="font-size: 0.7rem; color: rgba(255,255,255,0.6); margin-left: auto;">Premium Content</span>
            </div>
        </a>

        <!-- Search -->
        <div class="search-container" style="position: relative;">
            <i class="fas fa-search search-icon"></i>
                        <input type="search" id="search" name="search" class="search-input" placeholder="Suche..." autocomplete="off" disabled style="cursor: not-allowed; opacity: 0.5;">
            <p style="font-size: 0.7rem; color: rgba(255, 255, 255, 0.5); margin-top: 4px; text-align: center;">Du benötigst einen Rang zum Suchen</p>
                    </div>

        <!-- Online Counter -->
        <div class="online-counter">
            <div class="online-dot"></div>
            <span>
                93 online            </span>
        </div>

        <!-- Main Navigation -->
        <div class="nav-section">
            <div class="nav-section-title" style="display: flex; align-items: center; justify-content: space-between;">
                <span>Hauptmenü</span>
                <div class="notification-bell-container" style="margin-left: auto;">
                    <div class="notification-bell" onclick="toggleNotificationDropdown(event)">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge" id="desktopNotificationBadge" style="display: none;">0</span>
                    </div>
                    <div class="notification-dropdown" id="desktopNotificationDropdown">
                        <div class="notification-header">
                            <h3>Benachrichtigungen</h3>
                            <div class="notification-header-actions">
                                <button class="notification-mark-all" onclick="markAllNotificationsAsRead()">Alle als gelesen</button>
                                <button class="notification-delete-all" onclick="deleteAllNotifications()">Alle löschen</button>
                            </div>
                        </div>
                        <div class="notification-list" id="desktopNotificationList">
                            <div class="notification-empty">
                                <i class="fas fa-bell-slash"></i>
                                <p>Keine Benachrichtigungen</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <a href="/home" class="nav-item ">
                <div class="nav-item-icon">🏠</div>
                <div class="nav-item-text">Startseite</div>
            </a>
                        <a href="/referral_program" class="nav-item nav-item-free-access " onclick="trackReferralSidebarClick(event)">
                <div class="nav-item-icon">🎁</div>
                <div class="nav-item-text">Kostenlos Zugang</div>
            </a>
                        <a href="/customdl.php" class="nav-item active">
                <div class="nav-item-icon">📥</div>
                <div class="nav-item-text">Downloader</div>
            </a>
            <a href="/undress" class="nav-item " style="position: relative; overflow: hidden;">
                <div class="nav-item-icon">✨</div>
                <div class="nav-item-text" style="background: linear-gradient(90deg, #8b5cf6, #ec4899, #8b5cf6); background-size: 200% auto; -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; animation: gradient-shift 3s ease infinite; font-weight: 600;">AI Undress</div>
                <span style="position: absolute; top: 8px; right: 8px; background: linear-gradient(135deg, #8b5cf6, #ec4899); color: white; font-size: 9px; padding: 2px 6px; border-radius: 10px; font-weight: bold; animation: pulse-glow 2s ease-in-out infinite;">NEU</span>
            </a>
            <a href="/teenleaks" class="nav-item ">
                <div class="nav-item-icon">🔞</div>
                <div class="nav-item-text">Leaks</div>
            </a>
            <a href="/enhance.php" class="nav-item ">
                <div class="nav-item-icon">✨</div>
                <div class="nav-item-text">AI Enhancer</div>
            </a>
            <a href="/porntok" class="nav-item ">
                <div class="nav-item-icon">🎥</div>
                <div class="nav-item-text">PornTok</div>
            </a>
            <a href="/bbc" class="nav-item ">
                <div class="nav-item-icon">🍆</div>
                <div class="nav-item-text">Porn Videos</div>
            </a>
                    </div>

        <!-- Categories Dropdown -->
        <div class="nav-section">
            <div class="nav-section-title">Kategorien</div>
            <div class="nav-item" id="categoriesToggle" style="cursor: pointer;">
                <div class="nav-item-icon">📂</div>
                <div class="nav-item-text">Alle Kategorien</div>
                <div class="nav-item-chevron">
                    <i class="fas fa-chevron-right" style="font-size: 12px;"></i>
                </div>
            </div>
            <div class="nav-item-submenu" id="categoriesSubmenu">
                <a href="/home?c=0" class="nav-item " style="padding-left: 24px; text-decoration: none;"><div class="nav-item-icon" style="font-size: 16px;">🌐</div><div class="nav-item-text">Main</div></a><a href="/home?c=1" class="nav-item " style="padding-left: 24px; text-decoration: none;"><div class="nav-item-icon" style="font-size: 16px;">✨</div><div class="nav-item-text">Beliebt</div></a><a href="/home?c=2" class="nav-item " style="padding-left: 24px; text-decoration: none;"><div class="nav-item-icon" style="font-size: 16px;">❤️</div><div class="nav-item-text">Favoriten</div></a><a href="/home?c=27" class="nav-item " style="padding-left: 24px; text-decoration: none;"><div class="nav-item-icon" style="font-size: 16px;">💙</div><div class="nav-item-text">OnlyFans</div></a><a href="/home?c=29" class="nav-item " style="padding-left: 24px; text-decoration: none;"><div class="nav-item-icon" style="font-size: 16px;">🇩🇪</div><div class="nav-item-text">Deutsche</div></a><a href="/home?c=31" class="nav-item " style="padding-left: 24px; text-decoration: none;"><div class="nav-item-icon" style="font-size: 16px;">📁</div><div class="nav-item-text">Mega Post</div></a>            </div>
        </div>

        <!-- Shop Navigation -->
        <div class="nav-section">
            <div class="nav-section-title">Shop</div>
            <a href="/balance_accounts" class="nav-item " style="position: relative; overflow: hidden;">
                <div class="nav-item-icon">💰</div>
                <div class="nav-item-text" style="background: linear-gradient(90deg, #f59e0b, #ef4444, #f59e0b); background-size: 200% auto; -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; animation: gradient-shift 3s ease infinite; font-weight: 600;">OnlyFans Accounts</div>
                <span style="position: absolute; top: 8px; right: 8px; background: linear-gradient(135deg, #f59e0b, #ef4444); color: white; font-size: 9px; padding: 2px 6px; border-radius: 10px; font-weight: bold; animation: pulse-glow 2s ease-in-out infinite;">NEU</span>
            </a>
            <a href="/shop" class="nav-item">
                <div class="nav-item-icon">🛒</div>
                <div class="nav-item-text">Extra-Shop</div>
            </a>
            <a href="/rank_upgrade" class="nav-item">
                <div class="nav-item-icon">💎</div>
                <div class="nav-item-text">Rang Shop</div>
            </a>
            <a href="/upgrade" class="nav-item">
                <div class="nav-item-icon">⬆️</div>
                <div class="nav-item-text">Rang Upgraden</div>
            </a>
        </div>

        <!-- Extras -->
        <div class="nav-section">
            <div class="nav-section-title">Extras</div>
            <a href="/smash_or_pass" class="nav-item">
                <div class="nav-item-icon">❤️</div>
                <div class="nav-item-text">Smash/Pass</div>
            </a>
            <a href="/amateur" class="nav-item">
                <div class="nav-item-icon">📸</div>
                <div class="nav-item-text">Amateur Content</div>
            </a>
        </div>

        <!-- Account -->
        <div class="nav-section">
            <div class="nav-section-title">Account</div>
            <a href="/profile" class="nav-item ">
                <div class="nav-item-icon">👤</div>
                <div class="nav-item-text">Profil</div>
            </a>
            <a href="javascript:SignOut()" class="nav-item">
                <div class="nav-item-icon">🚪</div>
                <div class="nav-item-text">Logout</div>
            </a>
        </div>
    </nav>

    <!-- Sidebar Toggle -->
    <div class="sidebar-toggle" id="sidebarToggle">
        <i class="fas fa-chevron-left text-white"></i>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">

    <script>
        // Tracking für Referral Sidebar-Klicks
        function trackReferralSidebarClick(event) {
            // Tracking asynchron senden (blockiert Navigation nicht)
            fetch('/api/track_referral_event.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: 'event_type=sidebar_click',
                keepalive: true
            }).catch(err => console.error('Tracking error:', err));
            
            // Navigation normal weiterleiten
            // event.preventDefault() wird NICHT aufgerufen, damit der Link normal funktioniert
        }
        
        // Sidebar Toggle
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const toggleIcon = sidebarToggle.querySelector('i');
        const mobileOverlay = document.getElementById('mobileOverlay');
        const mobileSidebarToggle = document.getElementById('mobileSidebarToggle');

        // Desktop Toggle
        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
            if (sidebar.classList.contains('collapsed')) {
                toggleIcon.classList.remove('fa-chevron-left');
                toggleIcon.classList.add('fa-chevron-right');
            } else {
                toggleIcon.classList.remove('fa-chevron-right');
                toggleIcon.classList.add('fa-chevron-left');
            }
            localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
        });

        // Mobile Toggle - mit Body Scroll Lock für iOS
        mobileSidebarToggle?.addEventListener('click', () => {
            sidebar.classList.toggle('mobile-open');
            mobileOverlay.classList.toggle('active');
            // Verhindere Body-Scroll wenn Sidebar offen
            if (sidebar.classList.contains('mobile-open')) {
                document.body.style.overflow = 'hidden';
                document.body.style.position = 'fixed';
                document.body.style.width = '100%';
                document.body.style.top = `-${window.scrollY}px`;
            } else {
                const scrollY = document.body.style.top;
                document.body.style.overflow = '';
                document.body.style.position = '';
                document.body.style.width = '';
                document.body.style.top = '';
                window.scrollTo(0, parseInt(scrollY || '0') * -1);
            }
        });

        mobileOverlay.addEventListener('click', () => {
            sidebar.classList.remove('mobile-open');
            mobileOverlay.classList.remove('active');
            // Body-Scroll wieder aktivieren
            const scrollY = document.body.style.top;
            document.body.style.overflow = '';
            document.body.style.position = '';
            document.body.style.width = '';
            document.body.style.top = '';
            window.scrollTo(0, parseInt(scrollY || '0') * -1);
        });

        // Remember sidebar state
        const sidebarCollapsed = localStorage.getItem('sidebarCollapsed');
        if (sidebarCollapsed === 'true') {
            sidebar.classList.add('collapsed');
            toggleIcon.classList.remove('fa-chevron-left');
            toggleIcon.classList.add('fa-chevron-right');
        }

        // iOS Safari: Verhindere Scroll-Bleeding von Sidebar zur Hauptseite
        sidebar.addEventListener('touchmove', function(e) {
            // Erlaube Scrollen nur wenn Sidebar scrollbar ist
            const isScrollable = sidebar.scrollHeight > sidebar.clientHeight;
            const isAtTop = sidebar.scrollTop === 0;
            const isAtBottom = sidebar.scrollTop + sidebar.clientHeight >= sidebar.scrollHeight;
            
            // Bestimme Scroll-Richtung
            const touch = e.touches[0];
            const lastTouchY = sidebar._lastTouchY || touch.clientY;
            const deltaY = lastTouchY - touch.clientY;
            sidebar._lastTouchY = touch.clientY;
            
            // Verhindere Scroll wenn am Ende/Anfang und in diese Richtung gescrollt wird
            if (!isScrollable || (isAtTop && deltaY < 0) || (isAtBottom && deltaY > 0)) {
                e.preventDefault();
            }
        }, { passive: false });
        
        sidebar.addEventListener('touchstart', function(e) {
            sidebar._lastTouchY = e.touches[0].clientY;
        }, { passive: true });

        // Categories Dropdown Toggle
        const categoriesToggle = document.getElementById('categoriesToggle');
        const categoriesSubmenu = document.getElementById('categoriesSubmenu');

        if (categoriesToggle && categoriesSubmenu) {
            // Check if any category is active and expand automatically
            const hasActiveCategory = categoriesSubmenu.querySelector('.nav-item.active');
            if (hasActiveCategory) {
                categoriesSubmenu.classList.add('active');
                categoriesToggle.classList.add('expanded');
                console.log('Auto-expanded categories because active category found');
            }

            categoriesToggle.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                const isActive = categoriesSubmenu.classList.toggle('active');
                categoriesToggle.classList.toggle('expanded');

                console.log('Categories dropdown toggled:', isActive ? 'open' : 'closed');
            });

            // Log to verify element exists
            console.log('Categories toggle initialized');
        } else {
            console.error('Categories elements not found!', {
                toggle: !!categoriesToggle,
                submenu: !!categoriesSubmenu
            });
        }

        // Search Autocomplete
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search');
            const searchResults = document.getElementById('search-results');
            const searchResultsContainer = searchResults?.querySelector('.search-results-container');
            let searchTimeout;

            if (searchInput && searchResults && searchResultsContainer) {
                searchInput.addEventListener('input', function() {
                    const query = this.value.trim();

                    clearTimeout(searchTimeout);

                    if (query.length < 2) {
                        searchResults.classList.add('hidden');
                        return;
                    }

                    searchTimeout = setTimeout(() => {
                        const xhr = new XMLHttpRequest();
                        xhr.open('POST', 'search_suggestions.php', true);
                        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                        xhr.onload = function() {
                            if (xhr.status === 200) {
                                try {
                                    const results = JSON.parse(xhr.responseText);

                                    if (results.error) {
                                        searchResults.classList.add('hidden');
                                        return;
                                    }

                                    if (results && results.length > 0) {
                                        searchResultsContainer.innerHTML = results.map(result => `
                                            <a href="/gallery?post_id=${result.id}"
                                               class="block px-4 py-3 text-white hover:bg-[#373747] transition-colors" style="text-decoration: none;">
                                                <div class="flex items-center gap-3">
                                                    ${result.thumbnail ?
                                                        `<img src="./uploads/${result.thumbnail}" alt="${result.title}" class="w-10 h-10 rounded object-cover flex-shrink-0">` :
                                                        `<i class="fas fa-image text-gray-400 w-10 h-10 flex items-center justify-center"></i>`
                                                    }
                                                    <span class="flex-1 truncate">${result.title}</span>
                                                </div>
                                            </a>
                                        `).join('');
                                        searchResults.classList.remove('hidden');
                                    } else {
                                        searchResults.classList.add('hidden');
                                    }
                                } catch (e) {
                                    searchResults.classList.add('hidden');
                                }
                            }
                        };

                        xhr.onerror = function() {
                            searchResults.classList.add('hidden');
                        };

                        xhr.send('query=' + encodeURIComponent(query));
                    }, 300);
                });

                // Hide results when clicking outside
                document.addEventListener('click', function(e) {
                    if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                        searchResults.classList.add('hidden');
                    }
                });
            }
        });

        // Notification System
        let notificationUpdateInterval = null;
        
        function toggleNotificationDropdown(event) {
            event.stopPropagation();
            const isMobile = window.innerWidth < 768;
            const dropdown = isMobile ? document.getElementById('mobileNotificationDropdown') : document.getElementById('desktopNotificationDropdown');
            const bellButton = event.currentTarget;
            const isOpen = dropdown.classList.contains('show');
            
            // Schließe alle Dropdowns
            document.querySelectorAll('.notification-dropdown').forEach(d => {
                d.classList.remove('show');
                d.style.left = '';
                d.style.top = '';
                d.style.right = '';
                d.style.display = '';
            });
            
            if (!isOpen) {
                // Desktop: Verschiebe Dropdown außerhalb der Sidebar ins Body
                if (!isMobile) {
                    const bellRect = bellButton.getBoundingClientRect();
                    const sidebar = document.getElementById('sidebar');
                    
                    // Verschiebe Dropdown ins Body, falls es noch in der Sidebar ist
                    if (dropdown.parentElement && dropdown.parentElement.closest('.sidebar')) {
                        document.body.appendChild(dropdown);
                    }
                    
                    if (sidebar) {
                        const sidebarRect = sidebar.getBoundingClientRect();
                        dropdown.style.position = 'fixed';
                        dropdown.style.left = (sidebarRect.right + 8) + 'px';
                        dropdown.style.top = bellRect.top + 'px';
                        dropdown.style.right = 'auto';
                        dropdown.style.zIndex = '10001';
                        dropdown.style.display = 'block';
                    }
                }
                
                // Zeige Dropdown
                dropdown.classList.add('show');
                
                // Prüfe Position nach Rendering (nur Desktop)
                if (!isMobile) {
                    setTimeout(() => {
                        const dropdownRect = dropdown.getBoundingClientRect();
                        const sidebar = document.getElementById('sidebar');
                        if (sidebar) {
                            const sidebarRect = sidebar.getBoundingClientRect();
                            
                            // Prüfe ob Dropdown über den rechten Bildschirmrand hinausgeht
                            if (dropdownRect.right > window.innerWidth - 20) {
                                dropdown.style.left = 'auto';
                                dropdown.style.right = (window.innerWidth - sidebarRect.left + 8) + 'px';
                            }
                            
                            // Prüfe ob Dropdown über den unteren Bildschirmrand hinausgeht
                            if (dropdownRect.bottom > window.innerHeight - 20) {
                                dropdown.style.top = (window.innerHeight - dropdownRect.height - 20) + 'px';
                            }
                            
                            // Prüfe ob Dropdown über den oberen Bildschirmrand hinausgeht
                            if (dropdownRect.top < 20) {
                                dropdown.style.top = '20px';
                            }
                        }
                    }, 50);
                }
                
                loadNotifications();
            }
        }
        
        function loadNotifications() {
            fetch('/api/get_notifications.php')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        updateNotificationBadge(data.unread_count);
                        renderNotifications(data.notifications);
                    }
                })
                .catch(error => {
                    console.error('Error loading notifications:', error);
                });
        }
        
        function updateNotificationBadge(count) {
            const mobileBadge = document.getElementById('mobileNotificationBadge');
            const desktopBadge = document.getElementById('desktopNotificationBadge');
            
            if (count > 0) {
                // Zeige "9+" wenn mehr als 9 ungelesene Notifications
                const badgeText = count > 9 ? '9+' : count.toString();
                mobileBadge.textContent = badgeText;
                mobileBadge.style.display = 'block';
                desktopBadge.textContent = badgeText;
                desktopBadge.style.display = 'block';
            } else {
                mobileBadge.style.display = 'none';
                desktopBadge.style.display = 'none';
            }
        }
        
        function renderNotifications(notifications) {
            const isMobile = window.innerWidth < 768;
            const list = isMobile ? document.getElementById('mobileNotificationList') : document.getElementById('desktopNotificationList');
            
            if (notifications.length === 0) {
                list.innerHTML = `
                    <div class="notification-empty">
                        <i class="fas fa-bell-slash"></i>
                        <p>Keine Benachrichtigungen</p>
                    </div>
                `;
                return;
            }
            
            list.innerHTML = notifications.map(notif => {
                const icon = getNotificationIcon(notif.type);
                const unreadClass = notif.is_read ? '' : 'unread';
                return `
                    <div class="notification-item ${unreadClass}" onclick="handleNotificationClick(${notif.id}, '${notif.link || ''}')">
                        <div class="notification-icon">
                            <i class="${icon}"></i>
                        </div>
                        <div class="notification-content">
                            <div class="notification-title">${escapeHtml(notif.title)}</div>
                            <div class="notification-message">${escapeHtml(notif.message || '')}</div>
                            <div class="notification-time">${notif.time_ago}</div>
                        </div>
                        <div class="notification-item-actions" onclick="event.stopPropagation()">
                            ${!notif.is_read ? `
                                <button class="notification-action-btn mark-read" onclick="markNotificationAsRead(${notif.id}, event)" title="Als gelesen markieren">
                                    <i class="fas fa-check"></i>
                                </button>
                            ` : ''}
                            <button class="notification-action-btn delete" onclick="deleteNotification(${notif.id}, event)" title="Löschen">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                `;
            }).join('');
        }
        
        function getNotificationIcon(type) {
            const icons = {
                'customdl_complete': 'fas fa-download',
                'customdl_update': 'fas fa-sync-alt',
                'default': 'fas fa-bell'
            };
            return icons[type] || icons['default'];
        }
        
        function handleNotificationClick(notificationId, link) {
            // Markiere als gelesen
            fetch('/api/mark_notification_read.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `notification_id=${notificationId}`
            });
            
            // Schließe Dropdown
            document.querySelectorAll('.notification-dropdown').forEach(d => d.classList.remove('show'));
            
            // Navigiere zur Link-Zielseite
            if (link) {
                window.location.href = link;
            } else {
                // Fallback: Gehe zu CustomDL
                window.location.href = '/customdl.php';
            }
            
            // Aktualisiere Badge
            setTimeout(() => {
                loadNotifications();
            }, 500);
        }
        
        function markAllNotificationsAsRead() {
            fetch('/api/mark_all_notifications_read.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    loadNotifications();
                }
            })
            .catch(error => {
                console.error('Error marking all as read:', error);
            });
        }

        function deleteAllNotifications() {
            if (!confirm('Möchtest du wirklich alle Benachrichtigungen löschen?')) {
                return;
            }
            
            fetch('/api/delete_all_notifications.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    loadNotifications();
                }
            })
            .catch(error => {
                console.error('Error deleting all notifications:', error);
            });
        }

        function markNotificationAsRead(notificationId, event) {
            event.stopPropagation();
            
            fetch('/api/mark_notification_read.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `notification_id=${notificationId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    loadNotifications();
                }
            })
            .catch(error => {
                console.error('Error marking notification as read:', error);
            });
        }

        function deleteNotification(notificationId, event) {
            event.stopPropagation();
            
            fetch('/api/delete_notification.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `notification_id=${notificationId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    loadNotifications();
                }
            })
            .catch(error => {
                console.error('Error deleting notification:', error);
            });
        }
        
        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }
        
        // Schließe Dropdown beim Klick außerhalb
        document.addEventListener('click', function(e) {
            const bellContainer = e.target.closest('.notification-bell-container');
            const dropdown = e.target.closest('.notification-dropdown');
            const actionBtn = e.target.closest('.notification-action-btn');
            const headerBtn = e.target.closest('.notification-mark-all, .notification-delete-all');
            
            // Schließe nicht, wenn auf Bell, Dropdown, Action-Button oder Header-Button geklickt wird
            if (bellContainer || dropdown || actionBtn || headerBtn) {
                return;
            }
            
            // Schließe alle Dropdowns
            document.querySelectorAll('.notification-dropdown').forEach(d => {
                d.classList.remove('show');
                d.style.display = '';
            });
        });
        
        // Lade Notifications beim Seitenaufruf
        document.addEventListener('DOMContentLoaded', function() {
            loadNotifications();
            
            // Aktualisiere alle 30 Sekunden
            notificationUpdateInterval = setInterval(() => {
                loadNotifications();
            }, 30000);
        });
    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OFLeaks.tv - Custom Downloader</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        background: {
                            dark: '#080A14',
                            card: '#121520'
                        },
                        purple: {
                            300: '#c4b5fd',
                            400: '#a78bfa',
                            500: '#8b5cf6',
                            600: '#7c3aed',
                            900: '#4c1d95'
                        },
                        pink: {
                            400: '#f472b6',
                            500: '#ec4899',
                            600: '#db2777'
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif']
                    }
                }
            }
        }
    </script>
    
    <style>
        body {
            background-color: #080A14;
            color: #ffffff;
            font-family: 'Inter', sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .gradient-text {
            background: linear-gradient(135deg, #8b5cf6, #ec4899);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .search-container {
            background: rgba(18, 21, 32, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }

        .search-container:focus-within {
            border-color: #8b5cf6;
            box-shadow: 0 0 0 2px rgba(139, 92, 246, 0.2);
        }

        .tag {
            display: inline-block;
            padding: 1px .35em;
            border: 1px solid hsla(0, 0%, 0%, 0);
            border-radius: 4px;
            font-size: 80%;
            line-height: 1.26;
            text-decoration: none;
            line-height: inherit;
        }

        .tag.instagram {
            border: 1px solid hsl(336, 71%, 47%);
            color: #fff;
            background: #f09433;
            background: -moz-linear-gradient(45deg, hsl(31,86%,57%) 0, hsl(16,77%,57%) 25%, hsl(351,72%,51%) 50%, hsl(336,71%,47%) 75%, hsl(319,77%,42%) 100%);
            background: -webkit-linear-gradient(45deg, hsl(31, 86%, 57%) 0, hsl(16, 77%, 57%) 25%, hsl(351, 72%, 51%) 50%, hsl(336, 71%, 47%) 75%, hsl(319, 77%, 42%) 100%);
            background: linear-gradient(45deg, hsl(31, 86%, 57%) 0, hsl(16, 77%, 57%) 25%, hsl(351, 72%, 51%) 50%, hsl(336, 71%, 47%) 75%, hsl(319, 77%, 42%) 100%);
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#f09433', endColorstr='#bc1888', GradientType=1);
            text-shadow: .5px .5px hsl(0, 0%, 0%);
            font-weight: bold !important;
        }

        .tag.instagram:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(225, 48, 108, 0.3);
        }

        .tag.onlyfans {
            border: 1px solid hsl(0, 0%, 100%);
            border-radius: 3px;
            background-image: linear-gradient(to left bottom, hsl(197, 100%, 47%), hsl(197, 100%, 47%), hsl(192, 68%, 81%));
            color: #ffffff;
            font-weight: bold !important;
            text-shadow: .5px .5px hsl(0, 0%, 0%);
        }

        .tag.onlyfans:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 122, 255, 0.3);
        }

        .tag.fansly {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.2);
        }

        .tag.fansly:hover {
            background: rgba(255, 255, 255, 0.2);
            box-shadow: 0 4px 12px rgba(255, 255, 255, 0.15);
        }

        .tag.snapchat {
            border: 1px solid hsl(0, 0%, 100%);
            border-radius: 3px;
            background-image: linear-gradient(to left bottom, hsl(59, 100%, 50%), hsl(59, 100%, 50%), hsl(59, 100%, 70%), hsl(59, 100%, 70%));
            color: #000;
            font-weight: bold !important;
        }

        .tag.snapchat:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 252, 0, 0.3);
        }

        .tag.xxx {
            border: 1px solid hsl(0, 100%, 50%);
            border-radius: 3px;
            background-image: linear-gradient(to left bottom, hsl(0, 100%, 30%), hsl(0, 100%, 30%), hsl(0, 100%, 50%));
            color: #ffffff;
            font-weight: bold !important;
            text-shadow: .5px .5px hsl(0, 0%, 0%);
        }

        .tag.xxx:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 0, 0, 0.3);
        }

        .tag.patreon {
            border: 1px solid hsl(225, 9%, 9%);
            border-radius: 3px;
            background-image: linear-gradient(to left bottom, hsl(357, 100%, 63%), hsl(357, 100%, 63%), hsl(225, 9%, 9%));
            color: #ffffff;
            font-weight: bold !important;
            text-shadow: .5px .5px hsl(0, 0%, 0%);
        }

        .tag.patreon:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 66, 77, 0.3);
        }

        .tag.twitch {
            border: 1px solid hsl(0, 0%, 100%);
            border-radius: 3px;
            background-image: linear-gradient(to left bottom, hsl(264, 100%, 64%), hsl(264, 100%, 64%), hsl(261, 36%, 67%));
            color: #ffffff;
            font-weight: bold !important;
            text-shadow: .5px .5px hsl(0, 0%, 0%);
        }

        .tag.twitch:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(132, 89, 255, 0.3);
        }

        .tag.reddit {
            border: 1px solid hsl(0, 0%, 100%);
            border-radius: 3px;
            background-image: linear-gradient(to left bottom, hsl(20, 100%, 50%), hsl(20, 100%, 50%), hsl(16, 100%, 50%));
            color: #ffffff;
            font-weight: bold !important;
            text-shadow: .5px .5px hsl(0, 0%, 0%);
        }

        .tag.reddit:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 69, 0, 0.3);
        }

        .result-card {
            background: rgba(18, 21, 32, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }

        .result-card:hover {
            transform: translateY(-5px);
            border-color: rgba(139, 92, 246, 0.4);
        }

        .loading-spinner {
            border: 3px solid rgba(139, 92, 246, 0.1);
            border-top: 3px solid #8b5cf6;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @keyframes fade-in {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fade-in-slow {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fade-in 1s ease-out forwards;
        }
        .animate-fade-in-slow {
            animation: fade-in-slow 1.5s ease-out forwards;
        }

        /* Custom breakpoint for very small screens */
        @media (min-width: 400px) {
            .xs\:inline {
                display: inline !important;
            }
            .xs\:hidden {
                display: none !important;
            }
        }

        /* Mobile tab optimization */
        @media (max-width: 399px) {
            .tab-switcher-mobile {
                font-size: 11px;
            }
            .tab-switcher-mobile i {
                font-size: 12px;
            }
        }
    </style>
</head>
<body>
    <div class="min-h-screen">
        <!-- Hero Section -->
        <div class="relative overflow-hidden">
            <div class="py-12 flex items-center justify-center text-white">
                <div class="text-center space-y-4 px-4">
                    <!-- Highlight -->
                    <div class="text-sm md:text-base text-pink-500 tracking-widest uppercase animate-pulse">
                        DER EINZIGARTIGE
                    </div>

                    <!-- Main Headline -->
                    <h1 class="text-5xl md:text-7xl font-extrabold bg-gradient-to-r from-purple-400 via-pink-500 to-red-500 bg-clip-text text-transparent drop-shadow-lg animate-fade-in">
                        Custom Downloader
                    </h1>

                    <!-- Description -->
                    <p class="max-w-2xl mx-auto text-gray-300 text-lg md:text-xl leading-relaxed animate-fade-in-slow">
                        Lade exklusive Inhalte in Sekundenschnelle herunter: OnlyFans, Instagram, Patreon und mehr – direkt, sicher und anonym.
                    </p>
                </div>
            </div>
        </div>

        <!-- Search Section -->
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Token Display -->
            <div class="flex justify-center mb-6">
                <div class="bg-[#1a1d2e] rounded-xl p-2 flex items-center space-x-4 border border-gray-700">
                    <div class="flex items-center space-x-2 px-3 py-1.5 border-r border-gray-700">
                        <i class="fas fa-coins text-yellow-400"></i>
                        <span id="tokenCount" class="font-semibold">0</span>
                        <span class="text-gray-400">Tokens</span>
                    </div>
                    <button onclick="showRankRequiredModal()" class="bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 rounded-lg px-4 py-1.5 text-white font-semibold transition-all duration-300">
                        <i class="fas fa-shopping-cart mr-2"></i>Tokens kaufen
                    </button>
                </div>
            </div>

            <!-- Tab Switcher -->
            <div class="flex justify-center mb-6">
                <div class="bg-[#1a1d2e] rounded-xl p-1 inline-flex w-full max-w-md">
                    <button id="searchTab" class="tab-switcher-mobile flex-1 px-2 sm:px-4 py-2 rounded-lg text-white font-semibold transition-all duration-300 bg-gradient-to-r from-purple-500 to-pink-500 text-xs sm:text-sm">
                        <i class="fas fa-search mr-1 sm:mr-2"></i><span class="hidden xs:inline">Suche</span><span class="xs:hidden">Such</span>
                    </button>
                    <button id="myAreaTab" class="tab-switcher-mobile flex-1 px-2 sm:px-4 py-2 rounded-lg text-gray-400 font-semibold transition-all duration-300 hover:text-white text-xs sm:text-sm">
                        <i class="fas fa-user mr-1 sm:mr-2"></i><span class="hidden xs:inline">Downloads</span><span class="xs:hidden">Mein</span>
                    </button>
                    <button id="suggestionsTab" class="tab-switcher-mobile flex-1 px-2 sm:px-4 py-2 rounded-lg text-gray-400 font-semibold transition-all duration-300 hover:text-white text-xs sm:text-sm">
                        <i class="fas fa-magic mr-1 sm:mr-2"></i><span class="hidden xs:inline">Vorschläge</span><span class="xs:hidden">Tips</span>
                    </button>
                </div>
            </div>

            <!-- Info Box (wird nur im Eigener Bereich angezeigt) -->
            <div id="infoBox" class="bg-blue-500/10 border border-blue-500/20 rounded-xl p-4 mb-6 hidden">
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0">
                        <i class="fas fa-info-circle text-blue-400 text-xl"></i>
                    </div>
                    <div class="text-sm text-blue-200">
                        <p class="font-semibold mb-1">Wichtige Information:</p>
                        <p>Downloads, die sich aufhängen, werden nach 2 Stunden automatisch gelöscht. Dein Token wird dabei automatisch zurückerstattet.</p>
                    </div>
                </div>
            </div>

            <!-- Search Container / Wartungsmodus -->
                            <!-- Normaler Search Container -->
                <div id="searchContainer" class="search-container rounded-2xl p-6">
                    <!-- Admin Hinweis während Wartungsmodus -->
                                        
                    <form id="searchForm" class="space-y-4">
                        <div class="relative">
                            <input type="text" 
                                   id="searchInput" 
                                   class="w-full px-6 py-4 bg-[#1a1d2e] rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500"
                                   placeholder="Suche nach Inhalten"
                                   maxlength="25"
                                   pattern="[A-Za-zÄÖÜäöüß0-9\s\-_.]{3,25}$"
                                   autocomplete="off"
                                   required>
                            <button type="submit" 
                                    id="searchButton"
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 px-6 py-2 bg-gradient-to-r from-purple-500 to-pink-500 rounded-lg text-white font-semibold hover:from-purple-600 hover:to-pink-600 transition-all duration-300">
                                <i class="fas fa-search mr-2"></i>Suchen
                            </button>
                        </div>
                        <div class="flex flex-col items-center space-y-2">
                            <button type="button" onclick="showVideoTutorial()" class="text-purple-400 hover:text-purple-300 transition-colors duration-200 flex items-center space-x-2">
                                <i class="fas fa-play-circle"></i>
                                <span>Wie funktioniert's?</span>
                            </button>
                            <p class="text-sm text-gray-400 text-center">
                                Suche nach z.B. "Mia Khalifa", "Lia Engel", "Lucy Cat" etc.
                            </p>
                        </div>
                    </form>
                </div>
            
            <!-- Telegram Notification Box - Nur im Such-Tab und nur wenn nicht verbunden -->
                                    <div id="telegramBoxSearch" class="bg-gradient-to-r from-blue-500/10 to-purple-500/10 border border-blue-500/20 rounded-xl p-4 sm:p-5 mt-6">
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3">
                    <div class="flex items-center gap-3 flex-1">
                        <div class="w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fab fa-telegram text-white text-lg sm:text-xl"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-sm sm:text-base font-semibold text-white mb-1">
                                📱 Telegram Benachrichtigungen
                            </h3>
                            <p class="text-xs sm:text-sm text-gray-300">
                                Erhalte sofortige Updates zu deinen Downloads
                            </p>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-2 w-full sm:w-auto">
                                                    <button onclick="connectTelegramQuick()" class="bg-gradient-to-r from-blue-500 to-purple-500 hover:from-blue-600 hover:to-purple-600 text-white px-3 py-2 rounded-lg font-medium transition-all duration-300 flex items-center text-xs sm:text-sm w-full sm:w-auto justify-center">
                                <i class="fab fa-telegram mr-1 sm:mr-2"></i>Verbinden
                            </button>
                                            </div>
                </div>
            </div>
                    </div>

        <!-- Suggestions Section -->
        <div id="suggestionsContainer" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 hidden">
            <!-- Suggestions Header -->
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-white mb-4">
                    <i class="fas fa-magic text-purple-400 mr-3"></i>
                    Personalisierte Vorschläge
                </h2>
            </div>

            <!-- Suggestions Limit Info -->
            <div id="suggestionsLimitInfo" class="bg-blue-500/10 border border-blue-500/20 rounded-xl p-4 mb-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-blue-500/20 rounded-full flex items-center justify-center">
                            <i class="fas fa-clock text-blue-400"></i>
                        </div>
                        <div>
                            <h3 class="text-white font-semibold">Tägliche Vorschläge</h3>
                            <p class="text-blue-200 text-sm">
                                <span id="suggestionsRemaining">3</span>/3 Vorschläge verfügbar
                            </p>
                        </div>
                    </div>
                    <div id="nextRefreshTimer" class="text-right">
                        <p class="text-blue-200 text-sm">Nächste Erneuerung:</p>
                        <p class="text-white font-mono text-sm" id="refreshCountdown">--:--:--</p>
                    </div>
                </div>
            </div>

            <!-- Suggestions Content -->
            <div id="suggestionsContent">
                <!-- Content wird dynamisch geladen -->
            </div>
        </div>

        <!-- My Area Section -->
        <div id="myAreaContainer" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 hidden">
            <!-- Search Bar für My Area -->
            <div id="myAreaSearchContainer" class="mb-6 hidden">
                <div class="relative max-w-md mx-auto">
                    <div class="relative">
                        <input type="text" 
                               id="myAreaSearchInput" 
                               class="w-full px-4 py-3 pl-12 bg-[#1a1d2e] border border-gray-700 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-300"
                               placeholder="Durchsuche deine Downloads..."
                               autocomplete="off">
                        <div class="absolute left-4 top-1/2 transform -translate-y-1/2">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <button id="clearMyAreaSearch" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-white transition-colors duration-200 hidden">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    
                    <!-- Auto-Suggest Dropdown -->
                    <div id="myAreaSuggestions" class="absolute top-full left-0 right-0 mt-2 bg-[#1a1d2e] border border-purple-500/30 rounded-xl shadow-2xl z-50 max-h-96 overflow-y-auto hidden">
                        <!-- Suggestions werden hier dynamisch eingefügt -->
                    </div>
                </div>
            </div>

            <!-- Sortier-Controls -->
            <div id="sortControls" class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6 hidden">
                <div class="flex items-center space-x-3">
                    <span class="text-gray-400 text-sm font-medium">Sortieren nach:</span>
                    
                    <!-- Custom Dropdown -->
                    <div class="relative">
                        <button id="sortDropdownButton" class="bg-[#1a1d2e] border border-purple-500/30 rounded-xl px-4 py-2.5 text-white text-sm font-medium flex items-center space-x-2 hover:border-purple-500/50 transition-all duration-300 min-w-[200px] justify-between group">
                            <div class="flex items-center space-x-2">
                                <i id="sortIcon" class="fas fa-clock text-purple-400"></i>
                                <span id="sortText">Neueste zuerst</span>
                            </div>
                            <i class="fas fa-chevron-down text-gray-400 transform group-hover:text-purple-400 transition-all duration-300" id="dropdownChevron"></i>
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div id="sortDropdownMenu" class="absolute top-full left-0 right-0 mt-2 bg-[#1a1d2e] border border-purple-500/30 rounded-xl shadow-2xl z-50 overflow-hidden opacity-0 transform scale-95 pointer-events-none transition-all duration-200">
                            <div class="py-2">
                                <button data-sort="newest" class="sort-option w-full flex items-center space-x-3 px-4 py-3 text-sm text-gray-300 hover:bg-purple-500/10 hover:text-white transition-all duration-200 group">
                                    <i class="fas fa-clock text-purple-400 w-4"></i>
                                    <span>Neueste zuerst</span>
                                </button>
                                <button data-sort="oldest" class="sort-option w-full flex items-center space-x-3 px-4 py-3 text-sm text-gray-300 hover:bg-purple-500/10 hover:text-white transition-all duration-200 group">
                                    <i class="fas fa-history text-purple-400 w-4"></i>
                                    <span>Älteste zuerst</span>
                                </button>
                                <button data-sort="last_updated" class="sort-option w-full flex items-center space-x-3 px-4 py-3 text-sm text-gray-300 hover:bg-purple-500/10 hover:text-white transition-all duration-200 group">
                                    <i class="fas fa-sync-alt text-green-400 w-4"></i>
                                    <span>Zuletzt aktualisiert</span>
                                </button>
                                <div class="border-t border-gray-700 my-1"></div>
                                <button data-sort="most_images" class="sort-option w-full flex items-center space-x-3 px-4 py-3 text-sm text-gray-300 hover:bg-purple-500/10 hover:text-white transition-all duration-200 group">
                                    <i class="fas fa-image text-blue-400 w-4"></i>
                                    <span>Meiste Bilder</span>
                                </button>
                                <button data-sort="most_videos" class="sort-option w-full flex items-center space-x-3 px-4 py-3 text-sm text-gray-300 hover:bg-purple-500/10 hover:text-white transition-all duration-200 group">
                                    <i class="fas fa-video text-red-400 w-4"></i>
                                    <span>Meiste Videos</span>
                                </button>
                                <div class="border-t border-gray-700 my-1"></div>
                                <button data-sort="alphabetical_az" class="sort-option w-full flex items-center space-x-3 px-4 py-3 text-sm text-gray-300 hover:bg-purple-500/10 hover:text-white transition-all duration-200 group">
                                    <i class="fas fa-sort-alpha-down text-gray-400 w-4"></i>
                                    <span>A → Z</span>
                                </button>
                                <button data-sort="alphabetical_za" class="sort-option w-full flex items-center space-x-3 px-4 py-3 text-sm text-gray-300 hover:bg-purple-500/10 hover:text-white transition-all duration-200 group">
                                    <i class="fas fa-sort-alpha-up text-gray-400 w-4"></i>
                                    <span>Z → A</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Quick Stats -->
                <div id="quickStats" class="flex items-center space-x-4 text-sm text-gray-400">
                    <div class="flex items-center space-x-1">
                        <i class="fas fa-download text-purple-400"></i>
                        <span id="totalDownloads">0</span>
                        <span>Downloads</span>
                    </div>
                </div>
            </div>
            
            <!-- Downloads werden hier dynamisch eingefügt -->
        </div>

        <!-- Results Section -->
        <div id="results" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Results will be dynamically inserted here -->
        </div>

        <!-- Features and Tags Section -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Features Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Features -->
                <div class="bg-[#1a1d2e] rounded-2xl p-8">
                    <h2 class="text-2xl font-bold text-white mb-4">✨ Einzigartige Features</h2>
                    <ul class="text-left space-y-4 text-gray-300">
                        <li class="flex items-start">
                            <i class="fas fa-bolt text-purple-500 mt-1 mr-3"></i>
                            <span>Automatischer Download in deine Private Sammlung auf OFLeaks</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-shield-alt text-purple-500 mt-1 mr-3"></i>
                            <span>Sichere und lokale Speicherung aller Bilder</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-search text-purple-500 mt-1 mr-3"></i>
                            <span>Intelligente Suche über mehrere Plattformen hinweg</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-tags text-purple-500 mt-1 mr-3"></i>
                            <span>Automatische Kategorisierung durch Tags</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-infinity text-purple-500 mt-1 mr-3"></i>
                            <span>Permanenter Zugriff</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-sync-alt text-purple-500 mt-1 mr-3"></i>
                            <span>Wöchentliche Updates auf Knopfdruck</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-mobile-alt text-purple-500 mt-1 mr-3"></i>
                            <span>Optimiert für alle Geräte - Desktop & Mobile</span>
                        </li>
                    </ul>
                </div>

                <!-- Tags Section -->
                <div class="bg-[#1a1d2e] rounded-2xl p-8">
                    <h2 class="text-2xl font-bold text-white mb-4">🏷️ Tag-Erklärungen</h2>
                    <div class="space-y-4 text-left">
                        <div class="flex items-center">
                            <span class="tag instagram mr-3">Instagram</span>
                            <span class="text-gray-300">Instagram Profil | Ganze Profile, Stories, Reels, etc.</span>
                        </div>
                        <div class="flex items-center">
                            <span class="tag onlyfans mr-3">OnlyFans</span>
                            <span class="text-gray-300">Exklusive OnlyFans-Inhalte</span>
                        </div>
                        <div class="flex items-center">
                            <span class="tag patreon mr-3">Patreon</span>
                            <span class="text-gray-300">Premium Patreon-Inhalte</span>
                        </div>
                        <div class="flex items-center">
                            <span class="tag snapchat mr-3">Snapchat</span>
                            <span class="text-gray-300">Snapchat Leaks | Stories dieser Person</span>
                        </div>
                        <div class="flex items-center">
                            <span class="tag xxx mr-3">XXX</span>
                            <span class="text-gray-300">Porno Inhalte / Porno-Darsteller</span>
                        </div>
                        <div class="flex items-center">
                            <span class="tag twitch mr-3">Twitch</span>
                            <span class="text-gray-300">Twitch Streams & Clips | Exklusive Streamer-Inhalte</span>
                        </div>
                        <div class="flex items-center">
                            <span class="tag reddit mr-3">Reddit</span>
                            <span class="text-gray-300">Reddit Posts & Kommentare | Subreddit Inhalte</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Loading Indicator -->
        <div id="loading" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-[#1a1d2e] p-8 rounded-2xl text-center max-w-md mx-4">
                <div class="loading-spinner mx-auto mb-4"></div>
                <h3 class="text-xl font-semibold text-white mb-2">Suche läuft...</h3>
                <div class="text-gray-300 mb-4">
                    <p id="loadingStatus">Geschätzte Zeit: <span id="countdown">20</span> Sekunden</p>
                    <p id="loadingMessage" class="text-sm text-purple-400 mt-2">Bitte warten Sie einen Moment...</p>
                </div>
                <div class="w-full bg-gray-700 rounded-full h-2 mb-4">
                    <div id="progressBar" class="bg-gradient-to-r from-purple-500 to-pink-500 h-2 rounded-full transition-all duration-1000" style="width: 0%"></div>
                </div>
            </div>
        </div>

        <!-- Error Modal -->
        <div id="errorModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-[#1a1d2e] p-8 rounded-2xl text-center max-w-md mx-4">
                <div class="text-red-500 mb-4">
                    <i class="fas fa-exclamation-circle text-4xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-white mb-2">Suche fehlgeschlagen</h3>
                <p class="text-gray-300 mb-6">Bitte versuche es noch einmal.</p>
                <button onclick="closeErrorModal()" class="px-6 py-2 bg-purple-500 hover:bg-purple-600 rounded-lg text-white font-semibold transition-all duration-300">
                    Schließen
                </button>
            </div>
        </div>

        <!-- Loading Modal -->
        <div id="loadingModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-[#1a1d2e] p-8 rounded-2xl text-center max-w-md mx-4">
                <div class="text-4xl mb-6">
                    <i class="fas fa-exclamation-circle text-purple-500"></i>
                </div>
                <h3 class="text-2xl font-bold text-white mb-4">Sicher?</h3>
                <p class="text-gray-300 mb-8">Willst du den Content in deine Private Gallerie laden?</p>
                <div class="flex justify-center space-x-4">
                    <button onclick="closeLoadingModal()" class="px-8 py-3 bg-gray-600 hover:bg-gray-700 rounded-xl text-white font-semibold transition-all duration-300">
                        Nein
                    </button>
                    <button class="px-8 py-3 bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 rounded-xl text-white font-semibold transition-all duration-300">
                        Ja
                    </button>
                </div>
            </div>
        </div>

        <!-- Token Packages Modal -->
        <div id="tokenPackagesModal" class="hidden fixed inset-0 bg-black bg-opacity-75 backdrop-blur-sm flex items-start justify-center z-50 p-4 overflow-y-auto">
            <div class="bg-[#1a1d2e] rounded-2xl max-w-4xl w-full mx-auto my-8 overflow-hidden transform transition-all duration-300 scale-95 opacity-0" id="tokenModalContent">
                <!-- Header -->
                <div class="sticky top-0 z-10 bg-[#1a1d2e] p-6 border-b border-gray-700">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-2xl font-bold text-white">Token-Pakete</h3>
                            <p class="text-gray-400 mt-1">Wähle dein perfektes Paket</p>
                        </div>
                        <button onclick="closeTokenPackages()" class="text-gray-400 hover:text-white transition-colors duration-200">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>
                </div>

                <!-- Packages Grid -->
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Popular Package -->
                        <div class="bg-[#121520] rounded-xl p-6 border-2 border-purple-500 relative transform hover:-translate-y-1 transition-all duration-300">
                            <div class="absolute -top-3 left-1/2 transform -translate-x-1/2 bg-gradient-to-r from-purple-500 to-pink-500 text-white px-4 py-1 rounded-full text-sm font-semibold shadow-lg">
                                Beliebt
                            </div>
                            <div class="text-center mb-6">
                                <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-purple-500/10 mb-4">
                                    <i class="fas fa-crown text-yellow-500 text-xl"></i>
                                </div>
                                <h4 class="text-xl font-bold text-white mb-2">5 Tokens</h4>
                                <div class="flex items-baseline justify-center">
                                    <span class="text-4xl font-bold text-purple-500">14,99€</span>
                                    <span class="text-gray-400 ml-2">/5 Tokens</span>
                                </div>
                                <div class="mt-2 text-sm text-green-500 font-semibold">
                                    <i class="fas fa-tag mr-1"></i>20% Rabatt
                                </div>
                                <div class="mt-1 text-sm supreme-price">
                                                                            <div class="supreme-price-value text-yellow-500 font-semibold">
                                            <i class="fas fa-crown mr-1"></i>Supreme: 9,99€
                                        </div>
                                        <div class="text-gray-400 text-xs mt-1 supreme-upgrade">
                                            <a href="/rank_upgrade.php" class="hover:text-purple-400 transition-colors">
                                                <i class="fas fa-arrow-up mr-1"></i>Upgrade für Rabatt
                                            </a>
                                        </div>
                                                                    </div>
                            </div>
                            <ul class="space-y-3 mb-6">
                                <li class="flex items-center text-gray-300">
                                    <i class="fas fa-check text-green-500 mr-3"></i>
                                    <span>5 Tokens</span>
                                </li>
                                <li class="flex items-center text-gray-300">
                                    <i class="fas fa-check text-green-500 mr-3"></i>
                                    <span>
                                                                                    2,99€ pro Token
                                                                            </span>
                                </li>
                                <li class="flex items-center text-gray-300">
                                    <i class="fas fa-check text-green-500 mr-3"></i>
                                    <span>Beste Preis-Leistung</span>
                                </li>
                            </ul>
                                                        <div class="space-y-3">
                                <button onclick="startTokenPurchase('popular')" class="w-full bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 rounded-xl px-4 py-3 text-white font-semibold transition-all duration-300 flex items-center justify-center group">
                                    <i class="fas fa-credit-card mr-2"></i>
                                    <span>Mit Klarna / Kreditkarte zahlen</span>
                                    <i class="fas fa-arrow-right ml-2 transform group-hover:translate-x-1 transition-transform"></i>
                                </button>
                                <button onclick="startPayPalPurchase('popular')" class="w-full bg-gradient-to-r from-blue-400 to-blue-500 hover:from-blue-500 hover:to-blue-600 rounded-xl px-4 py-3 text-white font-semibold transition-all duration-300 flex items-center justify-center group">
                                    <i class="fab fa-paypal mr-2"></i>
                                    <span>Mit PayPal kaufen</span>
                                    <i class="fas fa-arrow-right ml-2 transform group-hover:translate-x-1 transition-transform"></i>
                                </button>
                            </div>
                                                    </div>

                        <!-- Premium Package -->
                        <div class="bg-[#121520] rounded-xl p-6 border border-gray-700 hover:border-purple-500 transition-all duration-300 transform hover:-translate-y-1">
                            <div class="text-center mb-6">
                                <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-purple-500/10 mb-4">
                                    <i class="fas fa-star text-yellow-500 text-xl"></i>
                                </div>
                                <h4 class="text-xl font-bold text-white mb-2">12 Tokens</h4>
                                <div class="flex items-baseline justify-center">
                                    <span class="text-4xl font-bold text-purple-500">29,99€</span>
                                    <span class="text-gray-400 ml-2">/12 Tokens</span>
                                </div>
                                <div class="mt-2 text-sm text-green-500 font-semibold">
                                    <i class="fas fa-tag mr-1"></i>33% Rabatt
                                </div>
                                <div class="mt-1 text-sm supreme-price">
                                                                            <div class="supreme-price-value text-yellow-500 font-semibold">
                                            <i class="fas fa-crown mr-1"></i>Supreme: 23,99€
                                        </div>
                                        <div class="text-gray-400 text-xs mt-1 supreme-upgrade">
                                            <a href="/rank_upgrade.php" class="hover:text-purple-400 transition-colors">
                                                <i class="fas fa-arrow-up mr-1"></i>Upgrade für Rabatt
                                            </a>
                                        </div>
                                                                    </div>
                            </div>
                            <ul class="space-y-3 mb-6">
                                <li class="flex items-center text-gray-300">
                                    <i class="fas fa-check text-green-500 mr-3"></i>
                                    <span>12 Tokens</span>
                                </li>
                                <li class="flex items-center text-gray-300">
                                    <i class="fas fa-check text-green-500 mr-3"></i>
                                    <span>
                                                                                    2,49€ pro Token
                                                                            </span>
                                </li>
                                <li class="flex items-center text-gray-300">
                                    <i class="fas fa-check text-green-500 mr-3"></i>
                                    <span>Maximaler Rabatt</span>
                                </li>
                            </ul>
                                                        <div class="space-y-3">
                                <button onclick="startTokenPurchase('premium')" class="w-full bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 rounded-xl px-4 py-3 text-white font-semibold transition-all duration-300 flex items-center justify-center group">
                                    <i class="fas fa-credit-card mr-2"></i>
                                    <span>Mit Klarna / Kreditkarte zahlen</span>
                                    <i class="fas fa-arrow-right ml-2 transform group-hover:translate-x-1 transition-transform"></i>
                                </button>
                                <button onclick="startPayPalPurchase('premium')" class="w-full bg-gradient-to-r from-blue-400 to-blue-500 hover:from-blue-500 hover:to-blue-600 rounded-xl px-4 py-3 text-white font-semibold transition-all duration-300 flex items-center justify-center group">
                                    <i class="fab fa-paypal mr-2"></i>
                                    <span>Mit PayPal kaufen</span>
                                    <i class="fas fa-arrow-right ml-2 transform group-hover:translate-x-1 transition-transform"></i>
                                </button>
                            </div>
                                                    </div>
                    </div>

                    <!-- Payment Methods -->
                    <div class="mt-8 pt-6 border-t border-gray-700">
                        <h4 class="text-lg font-semibold text-white mb-4">Akzeptierte Zahlungsmethoden</h4>
                        <div class="flex flex-wrap gap-4 justify-center">
                            <div class="bg-[#121520] p-3 rounded-lg">
                                <i class="fab fa-cc-visa text-2xl text-blue-500"></i>
                            </div>
                            <div class="bg-[#121520] p-3 rounded-lg">
                                <i class="fab fa-cc-mastercard text-2xl text-red-500"></i>
                            </div>
                            <div class="bg-[#121520] p-3 rounded-lg">
                                <i class="fab fa-cc-paypal text-2xl text-blue-400"></i>
                            </div>
                            <div class="bg-[#121520] p-3 rounded-lg">
                                <i class="fab fa-bitcoin text-2xl text-yellow-500"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Admin Button (nur für Admins) -->
        
        <!-- Video Tutorial Modal -->
        <div id="videoTutorialModal" class="hidden fixed inset-0 bg-black bg-opacity-75 backdrop-blur-sm flex items-start justify-center z-50 p-4 overflow-y-auto">
            <div class="bg-[#1a1d2e] rounded-2xl max-w-4xl w-full mx-auto p-6 my-8">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-bold text-white">Wie funktioniert der Custom Downloader?</h3>
                    <button onclick="closeVideoTutorial()" class="text-gray-400 hover:text-white transition-colors duration-200">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                <div class="max-w-[200px] md:max-w-xs mx-auto">
                    <div class="aspect-w-9 aspect-h-16 md:aspect-w-16 md:aspect-h-9">
                        <video id="tutorialVideo" 
                               class="w-full h-full rounded-xl object-contain bg-black" 
                               controls
                               preload="metadata"
                               loading="lazy"
                               playsinline
                               webkit-playsinline
                               x5-playsinline
                               x5-video-player-type="h5"
                               x5-video-player-fullscreen="true">
                               <source src="/customdl/videos/test_fixed.mp4?v=1770765359" type="video/mp4">
                            Dein Browser unterstützt keine Video-Wiedergabe.
                        </video>
                    </div>
                </div>
                <div class="mt-6 text-gray-300">
                    <h4 class="text-lg font-semibold text-white mb-3">So funktioniert's:</h4>
                    <ul class="list-inside space-y-2">
                        <li> 🔍 Suche nach dem gewünschten Content</li>
                        <li> 📥 Wähle einen Download aus den Suchergebnissen</li>
                        <li> 💰 Bestätige den Download</li>
                        <li> 🕒 Warte bis der Download abgeschlossen ist</li>
                        <li> 📂 Schau dir deine Downloads im "Downloads" Bereich an!</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Rank Required Modal -->
        <div id="rankRequiredModal" class="hidden fixed inset-0 bg-black bg-opacity-75 backdrop-blur-sm flex items-center justify-center z-50 p-4">
            <div class="bg-[#1a1d2e] rounded-2xl max-w-md w-full mx-auto p-6">
                <div class="text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-purple-500/10 mb-4">
                        <i class="fas fa-crown text-yellow-500 text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-4">Rang erforderlich</h3>
                    <p class="text-gray-300 mb-6">
                        Um Tokens kaufen zu können, benötigst du einen Rang. 
                        Upgrade jetzt deinen Account für exklusive Vorteile!
                    </p>
                    <div class="flex justify-center space-x-4">
                        <button onclick="closeRankRequiredModal()" class="px-6 py-3 bg-gray-600 hover:bg-gray-700 rounded-xl text-white font-semibold transition-all duration-300">
                            Später
                        </button>
                        <a href="/rank_upgrade.php" class="px-6 py-3 bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 rounded-xl text-white font-semibold transition-all duration-300">
                            Jetzt upgraden
                        </a>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <script>


        // Tab switching functionality
        const searchTab = document.getElementById('searchTab');
        const suggestionsTab = document.getElementById('suggestionsTab');
        const myAreaTab = document.getElementById('myAreaTab');
        const searchContainer = document.getElementById('searchContainer');
        const suggestionsContainer = document.getElementById('suggestionsContainer');
        const myAreaContainer = document.getElementById('myAreaContainer');
        const infoBox = document.getElementById('infoBox');
        
        // Variable für den Countdown-Interval
        let countdownInterval = null;
        
        // Aktuelle Sortierung global initialisieren
        let currentSort = 'newest';

        searchTab.addEventListener('click', () => {
            // Alle Tabs zurücksetzen
            resetAllTabs();
            
            searchTab.classList.add('bg-gradient-to-r', 'from-purple-500', 'to-pink-500', 'text-white');
            searchTab.classList.remove('text-gray-400');
            
            // Zeige den entsprechenden Container (Such- oder Wartungscontainer)
            const searchContainer = document.getElementById('searchContainer');
            const maintenanceContainer = document.getElementById('maintenanceContainer');
            
            if (searchContainer) searchContainer.classList.remove('hidden');
            if (maintenanceContainer) maintenanceContainer.classList.remove('hidden');
            
            suggestionsContainer.classList.add('hidden');
            myAreaContainer.classList.add('hidden');
            infoBox.classList.add('hidden');
            
            // Zeige Such-Telegram-Box falls vorhanden
            const telegramBoxSearch = document.getElementById('telegramBoxSearch');
            if (telegramBoxSearch) telegramBoxSearch.classList.remove('hidden');
        });

        suggestionsTab.addEventListener('click', () => {
            // Alle Tabs zurücksetzen
            resetAllTabs();
            
            suggestionsTab.classList.add('bg-gradient-to-r', 'from-purple-500', 'to-pink-500', 'text-white');
            suggestionsTab.classList.remove('text-gray-400');
            
            // Verstecke andere Container
            const searchContainer = document.getElementById('searchContainer');
            const maintenanceContainer = document.getElementById('maintenanceContainer');
            
            if (searchContainer) searchContainer.classList.add('hidden');
            if (maintenanceContainer) maintenanceContainer.classList.add('hidden');
            
            suggestionsContainer.classList.remove('hidden');
            myAreaContainer.classList.add('hidden');
            infoBox.classList.add('hidden');
            document.getElementById('results').innerHTML = '';
            
            // Verstecke Such-Telegram-Box
            const telegramBoxSearch = document.getElementById('telegramBoxSearch');
            if (telegramBoxSearch) telegramBoxSearch.classList.add('hidden');
            
            // Lade Vorschläge
            loadSuggestions();
        });

        myAreaTab.addEventListener('click', () => {
            // Alle Tabs zurücksetzen
            resetAllTabs();
            
            myAreaTab.classList.add('bg-gradient-to-r', 'from-purple-500', 'to-pink-500', 'text-white');
            myAreaTab.classList.remove('text-gray-400');
            myAreaContainer.classList.remove('hidden');
            
            // Verstecke andere Container
            const searchContainer = document.getElementById('searchContainer');
            const maintenanceContainer = document.getElementById('maintenanceContainer');
            
            if (searchContainer) searchContainer.classList.add('hidden');
            if (maintenanceContainer) maintenanceContainer.classList.add('hidden');
            
            suggestionsContainer.classList.add('hidden');
            
            // Info Box wird jetzt in displayUserDownloads() basierend auf Downloads gesteuert
            document.getElementById('results').innerHTML = ''; // Leere die Suchergebnisse nur beim Wechsel zum eigenen Bereich
            
            // Verstecke Such-Telegram-Box falls vorhanden
            const telegramBoxSearch = document.getElementById('telegramBoxSearch');
            if (telegramBoxSearch) telegramBoxSearch.classList.add('hidden');
            
            // Lade die Downloads des Benutzers (mit Verzögerung für Variable-Initialisierung)
            setTimeout(() => {
                loadUserDownloads();
            }, 0);
        });

        // Hilfsfunktion zum Zurücksetzen aller Tabs
        function resetAllTabs() {
            // Alle Tab-Styles zurücksetzen
            [searchTab, suggestionsTab, myAreaTab].forEach(tab => {
                tab.classList.remove('bg-gradient-to-r', 'from-purple-500', 'to-pink-500', 'text-white');
                tab.classList.add('text-gray-400');
            });
        }

        function showErrorModal() {
            document.getElementById('errorModal').classList.remove('hidden');
        }

        function closeErrorModal() {
            document.getElementById('errorModal').classList.add('hidden');
        }

        function showLoadingModal() {
            document.getElementById('loadingModal').classList.remove('hidden');
        }

        function closeLoadingModal() {
            document.getElementById('loadingModal').classList.add('hidden');
        }

        // Normalisiert deutsche Umlaute für die Suche (z. B. Wünsche -> Wuensche)
        function normalizeGermanUmlauts(str) {
            if (typeof str !== 'string') return '';
            return str
                .replace(/Ä/g, 'Ae')
                .replace(/Ö/g, 'Oe')
                .replace(/Ü/g, 'Ue')
                .replace(/ä/g, 'ae')
                .replace(/ö/g, 'oe')
                .replace(/ü/g, 'ue')
                .replace(/ß/g, 'ss');
        }

        const searchForm = document.getElementById('searchForm');
        if (searchForm) {
            searchForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            // Wartungsmodus-Prüfung für neue Downloads
                        
            const searchInput = document.getElementById('searchInput');
            const rawTerm = searchInput.value.trim();
            const searchTerm = normalizeGermanUmlauts(rawTerm);
            // Optional: Feld direkt aktualisieren, damit der Nutzer die Normalisierung sieht
            // searchInput.value = searchTerm;
            
            // Validate input
            if (!/^[A-Za-z0-9\s\-_.]{3,25}$/.test(searchTerm)) {
                alert('Bitte nur Buchstaben, Zahlen, Punkte, Leerzeichen, Bindestriche (-) und Unterstriche (_) eingeben (min. 3 & max. 25 Zeichen)');
                return;
            }
            
            // Beende vorherigen Countdown, falls vorhanden
            if (countdownInterval) {
                clearInterval(countdownInterval);
                countdownInterval = null;
            }
            
            // Show loading indicator and start countdown
            const loading = document.getElementById('loading');
            const countdown = document.getElementById('countdown');
            const progressBar = document.getElementById('progressBar');
            const loadingMessage = document.getElementById('loadingMessage');
            const loadingStatus = document.getElementById('loadingStatus');
            
            // Prüfe ob alle Elemente gefunden wurden
            if (!loading || !countdown || !progressBar || !loadingMessage || !loadingStatus) {
                console.error('Loading-Elemente nicht gefunden');
                showErrorModal();
                return;
            }
            
            loading.classList.remove('hidden');
            let timeLeft = 20;
            let progress = 0;
            
            countdownInterval = setInterval(() => {
                timeLeft--;
                progress = Math.min(((20 - timeLeft) / 20) * 100, 100);
                
                // Null-Checks für alle Elemente
                if (countdown) countdown.textContent = timeLeft;
                if (progressBar) progressBar.style.width = `${progress}%`;
                
                if (timeLeft <= 0) {
                    if (loadingMessage) loadingMessage.textContent = 'Einen Moment noch...';
                    if (loadingStatus) loadingStatus.textContent = 'Fast fertig...';
                    if (progressBar) progressBar.style.width = '100%';
                }
            }, 1000);
            
            try {
                // Call the script
                const response = await fetch('/customdl/search.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ searchTerm })
                });
                
                if (!response.ok) {
                    if (response.status === 408) {
                        showErrorModal();
                        return;
                    }
                    const errorData = await response.json();
                    if (errorData.error === 'Keine Berechtigung') {
                        showRankRequiredModal();
                        return;
                    }
                    throw new Error(errorData.error || 'Ein Fehler ist aufgetreten');
                }
                
                const data = await response.json();
                
                // Display results
                displayResults(data);
            } catch (error) {
                console.error('Error:', error);
                if (error.message === 'Keine Berechtigung') {
                    showRankRequiredModal();
                } else {
                    showErrorModal();
                }
            } finally {
                // Hide loading indicator and clear interval
                if (countdownInterval) {
                    clearInterval(countdownInterval);
                    countdownInterval = null;
                }
                loading.classList.add('hidden');
            }
            });
        }

        function displayResults(data) {
            const resultsContainer = document.getElementById('results');
            resultsContainer.innerHTML = ''; // Clear previous results
            
            if (!data || data.length === 0) {
                resultsContainer.innerHTML = `
                    <div class="text-center py-12">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-800 mb-4">
                            <i class="fas fa-search text-3xl text-gray-400"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-white mb-2">Keine Ergebnisse gefunden</h3>
                        <p class="text-gray-400 max-w-md mx-auto">
                            Es wurden leider keine Inhalte für deine Suche gefunden. 
                            Versuche es mit einem anderen Suchbegriff oder schaue später noch einmal vorbei.
                        </p>
                    </div>
                `;
                return;
            }
            
            // Create results grid
            const grid = document.createElement('div');
            grid.className = 'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6';
            
            data.forEach(item => {
                const card = document.createElement('div');
                card.className = 'result-card rounded-xl p-6';
                
                // Add content to card
                card.innerHTML = `
                    <div class="space-y-4">
                        <div class="relative">
                            <img src="${item.image.startsWith('/customdl/thumbnails/') ? item.image : item.image}" 
                                 alt="${item.title}" 
                                 class="rounded-xl w-full h-48 object-cover ${item.alreadyDownloaded ? 'opacity-50' : ''}"
                                 onerror="this.onerror=null; this.src='/customdl/thumbnails/no-image.jpg';" />
                            ${item.alreadyDownloaded ? `
                                <div class="absolute top-2 left-2 bg-green-500 text-white px-2 py-1 rounded-lg text-sm">
                                    <i class="fas fa-check mr-1"></i>Bereits geladen
                                </div>
                            ` : ''}
                        </div>
                        <h3 class="text-xl font-semibold text-white ${item.alreadyDownloaded ? 'opacity-50' : ''}">${item.title || 'Unbekannter Titel'}</h3>
                        <div class="flex flex-wrap gap-2 ${item.alreadyDownloaded ? 'opacity-50' : ''}">
                            ${item.tags ? item.tags.map(tag => {
                                const tagClass = tag.toLowerCase();
                                return `
                                    <span class="tag ${tagClass}">
                                        ${tag}
                                    </span>
                                `;
                            }).join('') : ''}
                        </div>
                        <button onclick="startDownloadWithTags('${item.link}', '${item.title.replace(/'/g, "\\'")}', '${item.image}', this)" 
                                data-tags='${JSON.stringify(item.tags || [])}'
                                class="w-full px-6 py-3 bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 rounded-xl text-white font-semibold transition-all duration-300 flex items-center justify-center ${item.alreadyDownloaded ? 'opacity-50 cursor-not-allowed' : ''}"
                                ${item.alreadyDownloaded ? 'disabled' : ''}>
                            <i class="fas fa-download mr-2"></i>
                            ${item.alreadyDownloaded ? 'Bereits geladen' : 'Laden'}
                        </button>
                    </div>
                `;
                
                grid.appendChild(card);
            });
            
            resultsContainer.appendChild(grid);
        }

        // Token Packages Modal Funktionen
        function showTokenPackages() {
            const modal = document.getElementById('tokenPackagesModal');
            const content = document.getElementById('tokenModalContent');
            
            // Supreme-Status wird jetzt direkt im PHP-Template gesetzt
            const supremePriceValues = document.querySelectorAll('.supreme-price-value');
            const upgradeLinks = document.querySelectorAll('.supreme-upgrade');
            
            // Prüfe ob User Supreme ist
            const isSupreme = false;
            
            if (isSupreme) {
                // Supreme User: Zeige normale Supreme-Preise
                supremePriceValues.forEach(el => {
                    el.classList.remove('line-through', 'opacity-50');
                });
                upgradeLinks.forEach(el => el.classList.add('hidden'));
            } else {
                // Nicht-Supreme User: Zeige durchgestrichene Preise mit Upgrade-Link
                supremePriceValues.forEach(el => {
                    el.classList.add('line-through', 'opacity-50');
                });
                upgradeLinks.forEach(el => el.classList.remove('hidden'));
            }

            modal.classList.remove('hidden');
            // Verhindere Scrollen im Hintergrund
            document.body.style.overflow = 'hidden';
            // Trigger reflow
            content.offsetHeight;
            content.classList.remove('scale-95', 'opacity-0');
        }

        function closeTokenPackages() {
            const modal = document.getElementById('tokenPackagesModal');
            const content = document.getElementById('tokenModalContent');
            content.classList.add('scale-95', 'opacity-0');
            // Erlaube Scrollen im Hintergrund wieder
            document.body.style.overflow = '';
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        // Schließe Modal bei Klick außerhalb
        const tokenPackagesModal = document.getElementById('tokenPackagesModal');
        if (tokenPackagesModal) {
            tokenPackagesModal.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeTokenPackages();
                }
            });
        }

        // Verhindere Scrollen im Modal selbst
        const tokenModalContent = document.getElementById('tokenModalContent');
        if (tokenModalContent) {
            tokenModalContent.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        }

        // Funktion zum Aktualisieren der Token-Anzeige
        function updateTokenDisplay(tokens) {
            const tokenCountElement = document.getElementById('tokenCount');
            if (tokenCountElement) {
                tokenCountElement.textContent = tokens;
            }
            
            // Aktiviere/Deaktiviere Suche basierend auf Token-Anzahl und Rang
            const searchInput = document.getElementById('searchInput');
            const searchButton = document.getElementById('searchButton');
            const hasRank = false;
            
            // Nur wenn Elemente existieren
            if (!searchInput || !searchButton) {
                console.log('Search elements not found, skipping token display update');
                return;
            }
            
            if (tokens < 1 || !hasRank) {
                searchInput.disabled = true;
                // Responsive placeholder text basierend auf Bildschirmgröße
                const isMobile = window.innerWidth < 640;
                if (!hasRank) {
                    searchInput.placeholder = isMobile ? 'Suchen' : 'Du benötigst einen Rang zum Suchen';
                } else {
                    searchInput.placeholder = isMobile ? 'Suchen' : 'Du benötigst Tokens zum Suchen';
                }
                searchInput.classList.add('opacity-50', 'cursor-not-allowed');
                searchButton.disabled = true;
                searchButton.classList.add('opacity-50', 'cursor-not-allowed');
                searchButton.classList.remove('hover:from-purple-600', 'hover:to-pink-600');
                searchButton.innerHTML = !hasRank ? '<i class="fas fa-crown mr-2"></i>Rang erforderlich' : '<i class="fas fa-lock mr-2"></i>Tokens erforderlich';
                
                // Füge eine zusätzliche Nachricht unter dem Button hinzu
                const searchContainer = document.querySelector('.search-container');
                let tokenMessage = document.getElementById('tokenMessage');
                if (!tokenMessage) {
                    tokenMessage = document.createElement('p');
                    tokenMessage.id = 'tokenMessage';
                    tokenMessage.className = 'text-sm text-gray-400 text-center mt-2';
                    searchContainer.appendChild(tokenMessage);
                }
                tokenMessage.textContent = !hasRank ? 'Du benötigst einen Rang zum Suchen' : 'Du benötigst Tokens zum Suchen';
            } else {
                searchInput.disabled = false;
                searchInput.placeholder = 'Suche nach Inhalten';
                searchInput.classList.remove('opacity-50', 'cursor-not-allowed');
                searchButton.disabled = false;
                searchButton.classList.remove('opacity-50', 'cursor-not-allowed');
                searchButton.classList.add('hover:from-purple-600', 'hover:to-pink-600');
                searchButton.innerHTML = '<i class="fas fa-search mr-2"></i>Suchen';
                
                // Entferne die zusätzliche Nachricht
                const tokenMessage = document.getElementById('tokenMessage');
                if (tokenMessage) {
                    tokenMessage.remove();
                }
            }
        }

        // Notification System
        function showNotification(message, type = 'info') {
            // Erstelle Notification Container falls nicht vorhanden
            let container = document.getElementById('notification-container');
            if (!container) {
                container = document.createElement('div');
                container.id = 'notification-container';
                container.className = 'fixed top-4 right-4 z-50 space-y-2';
                document.body.appendChild(container);
            }

            // Erstelle neue Notification
            const notification = document.createElement('div');
            notification.className = `bg-[#1a1d2e] border rounded-xl p-4 shadow-lg transform transition-all duration-300 translate-x-full`;
            
            // Setze Farbe basierend auf Typ
            switch(type) {
                case 'success':
                    notification.classList.add('border-green-500');
                    break;
                case 'error':
                    notification.classList.add('border-red-500');
                    break;
                case 'warning':
                    notification.classList.add('border-yellow-500');
                    break;
                default:
                    notification.classList.add('border-purple-500');
            }

            // Füge Icon basierend auf Typ hinzu
            let icon = '';
            switch(type) {
                case 'success':
                    icon = '<i class="fas fa-check-circle text-green-500 mr-2"></i>';
                    break;
                case 'error':
                    icon = '<i class="fas fa-exclamation-circle text-red-500 mr-2"></i>';
                    break;
                case 'warning':
                    icon = '<i class="fas fa-exclamation-triangle text-yellow-500 mr-2"></i>';
                    break;
                default:
                    icon = '<i class="fas fa-info-circle text-purple-500 mr-2"></i>';
            }

            notification.innerHTML = `
                <div class="flex items-center">
                    ${icon}
                    <span class="text-white">${message}</span>
                </div>
            `;

            // Füge Notification zum Container hinzu
            container.appendChild(notification);

            // Animation starten
            setTimeout(() => {
                notification.classList.remove('translate-x-full');
            }, 100);

            // Notification nach 5 Sekunden entfernen
            setTimeout(() => {
                notification.classList.add('translate-x-full');
                setTimeout(() => {
                    container.removeChild(notification);
                }, 300);
            }, 5000);
        }

        // Verbesserte Fehlerbehandlung für checkActiveDownload
        async function checkActiveDownload() {
            try {
                const response = await fetch('/customdl/check_active_download.php');
                if (!response.ok) {
                    throw new Error('Server-Fehler beim Prüfen des Downloads');
                }
                const data = await response.json();
                return data.hasActiveDownload;
            } catch (error) {
                console.error('Error checking active download:', error);
                showNotification('Fehler beim Prüfen des Downloads', 'error');
                return false;
            }
        }

        // Funktion zum Prüfen ob Download bereits existiert
        async function checkDownloadExists(link) {
            try {
                const response = await fetch('/customdl/check_download_exists.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ postLink: link })
                });
                const data = await response.json();
                return data.exists;
            } catch (error) {
                console.error('Error checking download exists:', error);
                return false;
            }
        }

        // Neue Wrapper-Funktion für Tags aus data-Attribut
        async function startDownloadWithTags(link, title, thumbnailLink, buttonElement) {
            const tags = JSON.parse(buttonElement.getAttribute('data-tags') || '[]');
            return startDownload(link, title, thumbnailLink, tags);
        }

        // Modifiziere die startDownload Funktion
        async function startDownload(link, title, thumbnailLink, tags = []) {
            // Prüfe zuerst ob der Download bereits existiert
            const downloadExists = await checkDownloadExists(link);
            
            // Nur bei neuen Downloads prüfen ob bereits ein Download läuft
            if (!downloadExists) {
            const hasActiveDownload = await checkActiveDownload();
            if (hasActiveDownload) {
                showNotification('Du lädst gerade schon etwas runter', 'error');
                return;
                }
            }

            // Prüfe ob genügend Tokens vorhanden sind
            const tokenCount = parseInt(document.getElementById('tokenCount').textContent);
            if (tokenCount < 1) {
                showNotification('Du benötigst 1 Token für diesen Download', 'error');
                showTokenPackages();
                return;
            }

            try {
                const response = await fetch('/customdl/start_download.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        postLink: link,
                        title: title,
                        thumbnailLink: thumbnailLink,
                        tags: tags
                    })
                });

                const data = await response.json();

                if (data.success) {
                    if (data.existing) {
                        showNotification('Download gestartet', 'success');
                    } else {
                        showNotification('Download gestartet', 'success');
                        // Aktualisiere Token-Anzeige
                        updateTokenDisplay(tokenCount - 1);
                    }
                    
                    // Wechsle zum "Eigener Bereich" Tab
                    myAreaTab.click();
                } else {
                    showNotification('Fehler beim Starten des Downloads', 'error');
                }
            } catch (error) {
                console.error('Download Error:', error);
                showNotification('Fehler beim Starten des Downloads', 'error');
            }
        }

        // Lade Token-Anzahl beim Start - auch im Wartungsmodus
        async function loadTokens() {
            console.log('Token loading started...'); // Debug
            try {
                const response = await fetch('/customdl/get_user_tokens.php');
                console.log('Token response:', response.status); // Debug
                const data = await response.json();
                console.log('Token data:', data); // Debug
                if (data.success) {
                    updateTokenDisplay(data.tokens);
                } else {
                    console.error('Token loading failed:', data.error);
                }
            } catch (error) {
                console.error('Error loading tokens:', error);
            }
        }
        
        // Token laden bei verschiedenen Events - mit Null-Checks
        if (window) {
            window.addEventListener('load', loadTokens);
        }
        if (document) {
            document.addEventListener('DOMContentLoaded', loadTokens);
        }
        
        // Zusätzlicher Token-Load nach 1 Sekunde für sicheren Fallback
        setTimeout(loadTokens, 1000);

        // Event Listener für Bildschirmgrößen-Änderungen (z.B. Handy drehen)
        window.addEventListener('resize', function() {
            const tokenCount = parseInt(document.getElementById('tokenCount').textContent);
            updateTokenDisplay(tokenCount); // Aktualisiere Placeholder bei Resize
        });

        // Funktion zum Laden der Benutzer-Downloads
        async function loadUserDownloads(page = 1, sort = null) {
            if (sort !== null) {
                currentSort = sort;
            }
            
            try {
                const response = await fetch('/customdl/get_user_downloads.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ 
                        page: page, 
                        sort: currentSort 
                    })
                });

                if (!response.ok) {
                    throw new Error('Fehler beim Laden der Downloads');
                }

                const data = await response.json();
                
                // Stelle sicher, dass wir im "Eigener Bereich" Tab sind
                if (myAreaContainer.classList.contains('hidden')) {
                    myAreaTab.click();
                }
                
                displayUserDownloads(data);
                
                // Bei Seitenwechsel (nicht bei erster Seite) nach oben zur Suchleiste scrollen
                if (page > 1) {
                    const searchContainer = document.getElementById('myAreaSearchContainer');
                    if (searchContainer) {
                        searchContainer.scrollIntoView({ 
                            behavior: 'smooth', 
                            block: 'start' 
                        });
                    }
                }
            } catch (error) {
                console.error('Error:', error);
                showNotification('Fehler beim Laden der Downloads', 'error');
            }
        }

        // Funktion zum Anzeigen der Benutzer-Downloads
        function displayUserDownloads(data) {
            const myAreaContainer = document.getElementById('myAreaContainer');
            const sortControls = document.getElementById('sortControls');
            const searchContainer = document.getElementById('myAreaSearchContainer');
            const infoBox = document.getElementById('infoBox');
            
            // Entferne ALLE bestehenden Inhalte außer Sort-Controls und Search-Container
            const childNodes = Array.from(myAreaContainer.children);
            childNodes.forEach(child => {
                if (child.id !== 'sortControls' && child.id !== 'myAreaSearchContainer') {
                    child.remove();
                }
            });

            if (!data.downloads || data.downloads.length === 0) {
                sortControls.classList.add('hidden');
                searchContainer.classList.add('hidden');
                infoBox.classList.add('hidden'); // Verstecke Info Box wenn keine Downloads
                const noDownloadsDiv = document.createElement('div');
                noDownloadsDiv.className = 'text-center py-12';
                noDownloadsDiv.innerHTML = `
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-800 mb-4">
                        <i class="fas fa-download text-3xl text-gray-400"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-2">Keine Downloads gefunden</h3>
                    <p class="text-gray-400 max-w-md mx-auto">
                        Du hast noch keine Downloads in deinem Bereich. 
                        Nutze die Suchfunktion, um Inhalte herunterzuladen.
                    </p>
                `;
                myAreaContainer.appendChild(noDownloadsDiv);
                return;
            }

            // Prüfe ob es nicht-fertige Downloads gibt (isReady = 0)
            const hasUnfinishedDownloads = data.downloads.some(download => !download.isReady);
            
            // Zeige Info Box nur wenn es nicht-fertige Downloads gibt
            if (hasUnfinishedDownloads) {
                infoBox.classList.remove('hidden');
            } else {
                infoBox.classList.add('hidden');
            }

            // Zeige Sort-Controls und Search-Container
            sortControls.classList.remove('hidden');
            searchContainer.classList.remove('hidden');
            
            // Update Stats
            document.getElementById('totalDownloads').textContent = data.downloads.length;

            // Grid für Downloads erstellen
            const grid = document.createElement('div');
            grid.className = 'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6';

            data.downloads.forEach(download => {
                const card = document.createElement('div');
                card.className = 'result-card rounded-xl p-6';
                
                // Extrahiere den Titel aus dem Ordnerpfad
                const title = download.folder_path.split('_').slice(1).join('_').replace(/_/g, ' ');
                
                // Bestimme den Bildpfad
                let imagePath = '/customdl/thumbnails/no-image.jpg';
                if (download.thumbnail_link) {
                    if (download.thumbnail_link.startsWith('http')) {
                        imagePath = download.thumbnail_link;
                    } else if (download.thumbnail_link.startsWith('/customdl/thumbnails/')) {
                        imagePath = download.thumbnail_link;
                    } else {
                        imagePath = '/customdl/thumbnails/' + download.thumbnail_link;
                    }
                }

                // Prüfe ob es ein Update ist
                const isUpdate = download.last_user_update !== null;
                
                // Prüfe ob der Post in den letzten 3 Tagen aktualisiert wurde
                const isRecentlyUpdated = download.is_recently_updated == 1;
                
                // Berechne die verbleibende Zeit basierend auf Update-Status
                let referenceTime, elapsedMinutes, remainingMinutes, isStuck;
                
                if (isUpdate) {
                    // Bei Updates: Verwende last_user_update als Referenz
                    referenceTime = new Date(download.last_user_update).getTime();
                    elapsedMinutes = Math.floor((new Date().getTime() - referenceTime) / (1000 * 60));
                    remainingMinutes = Math.max(0, 15 - elapsedMinutes);
                    // Updates können länger dauern, erst nach 45 Minuten als "hängend" betrachten
                    isStuck = elapsedMinutes > 45;
                } else {
                    // Bei neuen Downloads: Verwende created_at als Referenz
                    referenceTime = new Date(download.created_at).getTime();
                    elapsedMinutes = Math.floor((new Date().getTime() - referenceTime) / (1000 * 60));
                    remainingMinutes = Math.max(0, 15 - elapsedMinutes);
                    // Neue Downloads nach 25 Minuten als "hängend" betrachten
                    isStuck = elapsedMinutes > 60;
                }
                
                card.innerHTML = `
                    <div class="space-y-4">
                        <div class="relative">
                            <img src="${imagePath}" 
                                 alt="${title}" 
                                 class="rounded-xl w-full h-48 object-cover ${!download.isReady ? 'opacity-50' : ''}"
                                 onerror="this.onerror=null; this.src='/customdl/thumbnails/no-image.jpg';" />

                            
                            <!-- Aktualisiert Tag -->
                            ${isRecentlyUpdated && download.isReady ? `
                                <div class="absolute top-2 right-2 bg-green-500 text-white px-2 py-0.5 rounded text-xs font-medium shadow-lg">
                                    ${(() => {
                                        const seconds = download.seconds_since_update || 0;
                                        
                                        // Weniger als 1 Minute
                                        if (seconds < 60) {
                                            if (seconds <= 5) return 'Gerade aktualisiert';
                                            if (seconds === 1) return 'Aktualisiert vor 1 Sekunde';
                                            return `Aktualisiert vor ${seconds} Sekunden`;
                                        }
                                        
                                        // Minuten
                                        const minutes = Math.floor(seconds / 60);
                                        if (minutes < 60) {
                                            if (minutes === 1) return 'Aktualisiert vor 1 Minute';
                                            return `Aktualisiert vor ${minutes} Minuten`;
                                        }
                                        
                                        // Stunden
                                        const hours = Math.floor(minutes / 60);
                                        if (hours < 24) {
                                            if (hours === 1) return 'Aktualisiert vor 1 Stunde';
                                            return `Aktualisiert vor ${hours} Stunden`;
                                        }
                                        
                                        // Tage
                                        const days = Math.floor(hours / 24);
                                        if (days === 1) return 'Aktualisiert vor 1 Tag';
                                        return `Aktualisiert vor ${days} Tagen`;
                                    })()}
                                </div>
                            ` : ''}
                            ${!download.isReady ? `
                                <div class="absolute top-2 left-2 bg-yellow-500 text-white px-2 py-1 rounded-lg text-sm">
                                    <i class="fas fa-clock mr-1"></i>${isUpdate ? 'Wird aktualisiert...' : 'Wird geladen...'}
                                </div>
                                <div class="absolute bottom-2 left-2 right-2 bg-black bg-opacity-75 text-white px-2 py-1 rounded-lg text-sm">
                                    ${isStuck ? 
                                        (isUpdate ? 
                                            '<i class="fas fa-exclamation-triangle mr-1"></i>Das Update dauert ungewöhnlich lange' : 
                                            '<i class="fas fa-exclamation-triangle mr-1"></i>Es kann sein, dass sich der Download aufgehängt hat') : 
                                        remainingMinutes > 0 ? 
                                            `<i class="fas fa-hourglass-half mr-1"></i>Geschätzte Zeit: ${remainingMinutes} Minuten` : 
                                            (isUpdate ? 
                                                '<i class="fas fa-hourglass-half mr-1"></i>Update läuft noch...' : 
                                                '<i class="fas fa-hourglass-half mr-1"></i>Einen kleinen Moment noch...')}
                                </div>
                                ${((isStuck && !isUpdate) || false) ? `
                                    <button onclick="cancelDownload('${download.folder_path}', ${download.id})" 
                                            class="absolute top-2 right-2 bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg text-sm transition-colors duration-300">
                                        <i class="fas fa-times mr-1"></i>Abbrechen
                                    </button>
                                ` : ''}
                            ` : ''}
                        </div>
                        <h3 class="text-xl font-semibold text-white ${!download.isReady ? 'opacity-50' : ''}">${title}</h3>
                        
                        <!-- Datum-Informationen -->
                        <div class="text-xs text-gray-400 space-y-0.5 mb-2 ${!download.isReady ? 'opacity-50' : ''}">
                            <div>Hinzugefügt am: ${new Date(download.assigned_at || download.created_at).toLocaleDateString('de-DE')}</div>
                            <div>Zuletzt aktualisiert: ${download.last_update ? new Date(download.last_update).toLocaleDateString('de-DE') : '/'}</div>
                        </div>
                        
                        <div class="flex flex-wrap gap-2 ${!download.isReady ? 'opacity-50' : ''}">
                            ${(() => {
                                // Parse Tags aus der Datenbank
                                const tags = download.tags ? download.tags.split(',') : ['OnlyFans'];
                                return tags.map(tag => {
                                    const tagClass = tag.toLowerCase().trim();
                                    return `<span class="tag ${tagClass}">${tag.trim()}</span>`;
                                }).join('');
                            })()}
                            ${download.isReady ? `
                                <div class="flex items-center space-x-4 text-sm text-gray-400">
                                    <div class="flex items-center">
                                        <i class="fas fa-image text-purple-500 mr-1"></i>
                                        <span>${download.images} Bilder</span>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-video text-purple-500 mr-1"></i>
                                        <span>${download.videos} Videos</span>
                                    </div>
                                </div>
                            ` : ''}
                        </div>
                        <button onclick="viewDownload('${download.folder_path}')" 
                                class="w-full px-6 py-3 bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 rounded-xl text-white font-semibold transition-all duration-300 flex items-center justify-center ${!download.isReady ? 'opacity-50 cursor-not-allowed' : ''}"
                                ${!download.isReady ? 'disabled' : ''}>
                            <i class="fas fa-eye mr-2"></i>
                            ${!download.isReady ? 'Wird geladen...' : 'Ansehen'}
                        </button>
                    </div>
                `;
                
                grid.appendChild(card);
            });

            myAreaContainer.appendChild(grid);

            // Pagination hinzufügen, wenn nötig
            if (data.total_pages > 1) {
                const paginationContainer = document.createElement('div');
                paginationContainer.className = 'pagination-container mt-8';
                
                const pagination = document.createElement('div');
                pagination.className = 'flex justify-center space-x-2';
                
                // Zurück-Button
                if (data.current_page > 1) {
                    const prevButton = document.createElement('button');
                    prevButton.innerHTML = '<i class="fas fa-chevron-left"></i>';
                    prevButton.className = 'px-4 py-2 rounded-lg bg-gray-700 text-gray-300 hover:bg-gray-600 transition-colors duration-200';
                    prevButton.onclick = function() {
                        loadUserDownloads(data.current_page - 1, currentSort);
                    };
                    pagination.appendChild(prevButton);
                }

                // Seitenzahlen (max 5 sichtbare Seiten)
                const maxVisiblePages = 5;
                const startPage = Math.max(1, data.current_page - Math.floor(maxVisiblePages / 2));
                const endPage = Math.min(data.total_pages, startPage + maxVisiblePages - 1);
                
                for (let i = startPage; i <= endPage; i++) {
                    const pageNum = i;
                    const pageButton = document.createElement('button');
                    pageButton.className = `px-4 py-2 rounded-lg transition-colors duration-200 ${
                        pageNum === data.current_page 
                            ? 'bg-purple-500 text-white shadow-lg' 
                            : 'bg-gray-700 text-gray-300 hover:bg-gray-600'
                    }`;
                    pageButton.textContent = pageNum;
                    pageButton.onclick = function() {
                        loadUserDownloads(pageNum, currentSort);
                    };
                    pagination.appendChild(pageButton);
                }

                // Weiter-Button
                if (data.current_page < data.total_pages) {
                    const nextButton = document.createElement('button');
                    nextButton.innerHTML = '<i class="fas fa-chevron-right"></i>';
                    nextButton.className = 'px-4 py-2 rounded-lg bg-gray-700 text-gray-300 hover:bg-gray-600 transition-colors duration-200';
                    nextButton.onclick = function() {
                        loadUserDownloads(data.current_page + 1, currentSort);
                    };
                    pagination.appendChild(nextButton);
                }
                
                paginationContainer.appendChild(pagination);
                myAreaContainer.appendChild(paginationContainer);
            }
        }

        // Funktion zum Ansehen eines Downloads
        function viewDownload(folderPath) {
            window.location.href = `/customdl/gallery.php?path=${encodeURIComponent(folderPath)}`;
        }

        // Prüfe auf Hash-Parameter beim Laden der Seite
        window.addEventListener('load', function() {
            const hash = window.location.hash;

            if (hash.startsWith('#myArea')) {
                setTimeout(() => myAreaTab.click(), 100);
            } else if (hash.startsWith('#suggestions')) {
                setTimeout(() => suggestionsTab.click(), 100);
            }
        });

        // Admin Stats Funktionen
        function showAdminStats() {
            const modal = document.getElementById('adminStatsModal');
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            
            // Lade Statistiken
            loadAdminStats();
        }

        function closeAdminStats() {
            const modal = document.getElementById('adminStatsModal');
            modal.classList.add('hidden');
            document.body.style.overflow = '';
        }

        async function loadAdminStats() {
            try {
                const response = await fetch('/customdl/get_admin_stats.php');
                if (!response.ok) throw new Error('Fehler beim Laden der Statistiken');
                
                const data = await response.json();
                
                const statsContent = document.getElementById('adminStatsContent');
                statsContent.innerHTML = `
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div class="bg-[#121520] rounded-xl p-4">
                            <h4 class="text-lg font-semibold text-white mb-3">Downloads Ordner</h4>
                            <div class="space-y-2">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-400">Größe:</span>
                                    <span class="text-white font-mono">${data.downloads_size}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-400">Dateien:</span>
                                    <span class="text-white font-mono">${data.downloads_files}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-400">Ordner:</span>
                                    <span class="text-white font-mono">${data.downloads_folders}</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-[#121520] rounded-xl p-4">
                            <h4 class="text-lg font-semibold text-white mb-3">VPS Speicher</h4>
                            <div class="space-y-2">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-400">Gesamt:</span>
                                    <span class="text-white font-mono">${data.vps_total}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-400">Verwendet:</span>
                                    <span class="text-white font-mono">${data.vps_used}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-400">Frei:</span>
                                    <span class="text-white font-mono">${data.vps_free}</span>
                                </div>
                                <div class="w-full bg-gray-700 rounded-full h-2 mt-2">
                                    <div class="bg-gradient-to-r from-purple-500 to-pink-500 h-2 rounded-full" style="width: ${data.vps_used_percent}%"></div>
                                </div>
                                <div class="text-right text-sm text-gray-400">
                                    ${data.vps_used_percent}% verwendet
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-[#121520] rounded-xl p-4">
                            <h4 class="text-lg font-semibold text-white mb-3">
                                <i class="fas fa-magic text-purple-400 mr-2"></i>Vorschläge heute
                            </h4>
                            <div class="space-y-2">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-400">Aktive Benutzer:</span>
                                    <span class="text-white font-mono">${data.suggestions_users_today || 0}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-400">Verwendet:</span>
                                    <span class="text-white font-mono">${data.suggestions_used_today || 0}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-400">Verfügbar:</span>
                                    <span class="text-white font-mono">${data.suggestions_total_available || 0}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-400">Verbleibend:</span>
                                    <span class="text-white font-mono">${data.suggestions_remaining_today || 0}</span>
                                </div>
                                <div class="w-full bg-gray-700 rounded-full h-2 mt-2">
                                    <div class="bg-gradient-to-r from-purple-500 to-pink-500 h-2 rounded-full" style="width: ${data.suggestions_total_available > 0 ? Math.round((data.suggestions_used_today / data.suggestions_total_available) * 100) : 0}%"></div>
                                </div>
                                <div class="text-right text-sm text-gray-400">
                                    ${data.suggestions_total_available > 0 ? Math.round((data.suggestions_used_today / data.suggestions_total_available) * 100) : 0}% genutzt
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            } catch (error) {
                console.error('Error loading admin stats:', error);
                showNotification('Fehler beim Laden der Statistiken', 'error');
            }
        }

        // Schließe Modal bei Klick außerhalb
        document.getElementById('adminStatsModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeAdminStats();
            }
        });

        // Funktion zum Starten des Token-Kaufs
        async function startTokenPurchase(packageType) {
            try {
                const response = await fetch('/process_token_purchase.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ package_type: packageType })
                });

                const data = await response.json();

                if (data.success) {
                    // Weiterleitung zur Stripe Checkout-Seite
                    window.location.href = data.redirect_url;
                } else {
                    showNotification(data.message || 'Fehler beim Starten des Kaufs', 'error');
                }
            } catch (error) {
                console.error('Token Purchase Error:', error);
                showNotification('Fehler beim Starten des Kaufs', 'error');
            }
        }

        // Funktion zum Starten des PayPal Token-Kaufs
        async function startPayPalPurchase(packageType) {
            try {
                const response = await fetch('/process_paypal_token_purchase.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ package_type: packageType })
                });

                const data = await response.json();

                if (data.success) {
                    // Weiterleitung zur PayPal Checkout-Seite
                    window.location.href = data.redirect_url;
                } else {
                    showNotification(data.message || 'Fehler beim Starten des PayPal-Kaufs', 'error');
                }
            } catch (error) {
                console.error('PayPal Purchase Error:', error);
                showNotification('Fehler beim Starten des PayPal-Kaufs', 'error');
            }
        }

        // Füge die cancelDownload Funktion zum JavaScript hinzu
        async function cancelDownload(folderPath, downloadId) {
            // Prüfe ob bereits ein Cancel-Request läuft
            const buttonId = `cancel-btn-${downloadId}`;
            const cancelButton = document.querySelector(`[onclick*="cancelDownload('${folderPath}', ${downloadId})"]`);
            
            if (cancelButton && cancelButton.disabled) {
                console.log('Cancel-Request läuft bereits');
                return;
            }

            if (!confirm('Möchtest du diesen Download wirklich abbrechen? Du erhältst deinen Token zurück.')) {
                return;
            }

            // Button deaktivieren und visuell ändern
            if (cancelButton) {
                cancelButton.disabled = true;
                cancelButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i>Abbreche...';
                cancelButton.classList.add('opacity-50', 'cursor-not-allowed');
            }

            try {
                const response = await fetch('/customdl/cancel_download.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        folder_path: folderPath,
                        download_id: downloadId
                    })
                });

                const data = await response.json();

                if (data.success) {
                    showNotification('Download abgebrochen - Token wurde zurückerstattet', 'success');
                    // Aktualisiere Token-Anzeige
                    updateTokenDisplay(parseInt(document.getElementById('tokenCount').textContent) + 1);
                    // Aktualisiere die Download-Liste
                    loadUserDownloads();
                } else {
                    showNotification(data.message || 'Fehler beim Abbrechen des Downloads', 'error');
                    // Button wieder aktivieren bei Fehler
                    if (cancelButton) {
                        cancelButton.disabled = false;
                        cancelButton.innerHTML = '<i class="fas fa-times mr-1"></i>Abbrechen';
                        cancelButton.classList.remove('opacity-50', 'cursor-not-allowed');
                    }
                }
            } catch (error) {
                console.error('Cancel Download Error:', error);
                showNotification('Fehler beim Abbrechen des Downloads', 'error');
                // Button wieder aktivieren bei Fehler
                if (cancelButton) {
                    cancelButton.disabled = false;
                    cancelButton.innerHTML = '<i class="fas fa-times mr-1"></i>Abbrechen';
                    cancelButton.classList.remove('opacity-50', 'cursor-not-allowed');
                }
            }
        }

        // Video Tutorial Funktionen
        function showVideoTutorial() {
            const modal = document.getElementById('videoTutorialModal');
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            
            // Video automatisch starten
            const video = document.getElementById('tutorialVideo');
            video.play();
        }

        function closeVideoTutorial() {
            const modal = document.getElementById('videoTutorialModal');
            const video = document.getElementById('tutorialVideo');
            
            // Video stoppen
            video.pause();
            video.currentTime = 0;
            
            modal.classList.add('hidden');
            document.body.style.overflow = '';
        }

        // Schließe Modal bei Klick außerhalb
        document.getElementById('videoTutorialModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeVideoTutorial();
            }
        });

        // Rank Required Modal Funktionen
        function showRankRequiredModal() {
            const modal = document.getElementById('rankRequiredModal');
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeRankRequiredModal() {
            const modal = document.getElementById('rankRequiredModal');
            modal.classList.add('hidden');
            document.body.style.overflow = '';
        }

        // Schließe Modal bei Klick außerhalb
        document.getElementById('rankRequiredModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeRankRequiredModal();
            }
        });

        // Telegram Quick Connect Funktionen
        function connectTelegramQuick() {
                            const botUsername = 'ofleaks_userbot';
                const userId = 19723;
                const telegramUrl = `https://t.me/${botUsername}?start=connect_${userId}`;
                window.open(telegramUrl, '_blank');
                
                // Zeige Hinweis
                showNotification('Telegram-Verbindung wird hergestellt. Folge den Anweisungen im Bot!', 'info');
                
                // Prüfe alle 5 Sekunden für 2 Minuten, ob Verbindung hergestellt wurde
                let checkCount = 0;
                const maxChecks = 24; // 2 Minuten
                
                const checkConnection = setInterval(() => {
                    checkCount++;
                    
                    fetch('/check_telegram_connection.php?user_id=19723')
                        .then(response => response.json())
                        .then(data => {
                            if (data.connected) {
                                clearInterval(checkConnection);
                                showNotification('🎉 Telegram erfolgreich verbunden! Du erhältst jetzt Benachrichtigungen.', 'success');
                                setTimeout(() => {
                                    location.reload();
                                }, 2000);
                            } else if (checkCount >= maxChecks) {
                                clearInterval(checkConnection);
                                showNotification('Verbindung noch nicht erkannt. Aktualisiere die Seite manuell.', 'warning');
                            }
                        })
                        .catch(error => {
                            console.error('Error checking Telegram status:', error);
                        });
                }, 5000);
                    }

        function disconnectTelegram() {
            if (confirm('Möchtest du die Telegram-Verbindung wirklich trennen? Du erhältst dann keine Benachrichtigungen mehr.')) {
                fetch('/disconnect_telegram.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showNotification('Telegram-Verbindung erfolgreich getrennt.', 'success');
                        setTimeout(() => {
                            location.reload();
                        }, 2000);
                    } else {
                        showNotification('Fehler beim Trennen der Verbindung: ' + data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Ein Fehler ist aufgetreten.', 'error');
                });
            }
        }

        // Update Memory für domain preference
                
                 // Sort Dropdown Funktionalität
         document.addEventListener('DOMContentLoaded', function() {
             const dropdownButton = document.getElementById('sortDropdownButton');
             const dropdownMenu = document.getElementById('sortDropdownMenu');
             const dropdownChevron = document.getElementById('dropdownChevron');
             const sortIcon = document.getElementById('sortIcon');
             const sortText = document.getElementById('sortText');
             let isDropdownOpen = false;

             // Sortier-Optionen Mapping
             const sortOptions = {
                 'newest': { icon: 'fas fa-clock', text: 'Neueste zuerst', color: 'text-purple-400' },
                 'oldest': { icon: 'fas fa-history', text: 'Älteste zuerst', color: 'text-purple-400' },
                 'last_updated': { icon: 'fas fa-sync-alt', text: 'Zuletzt aktualisiert', color: 'text-green-400' },
                 'most_images': { icon: 'fas fa-image', text: 'Meiste Bilder', color: 'text-blue-400' },
                 'most_videos': { icon: 'fas fa-video', text: 'Meiste Videos', color: 'text-red-400' },
                 'alphabetical_az': { icon: 'fas fa-sort-alpha-down', text: 'A → Z', color: 'text-gray-400' },
                 'alphabetical_za': { icon: 'fas fa-sort-alpha-up', text: 'Z → A', color: 'text-gray-400' }
             };

             // Toggle Dropdown
             dropdownButton.addEventListener('click', function(e) {
                 e.stopPropagation();
                 toggleDropdown();
             });

             function toggleDropdown() {
                 isDropdownOpen = !isDropdownOpen;
                 
                 if (isDropdownOpen) {
                     dropdownMenu.classList.remove('opacity-0', 'scale-95', 'pointer-events-none');
                     dropdownMenu.classList.add('opacity-100', 'scale-100');
                     dropdownChevron.style.transform = 'rotate(180deg)';
                 } else {
                     dropdownMenu.classList.add('opacity-0', 'scale-95', 'pointer-events-none');
                     dropdownMenu.classList.remove('opacity-100', 'scale-100');
                     dropdownChevron.style.transform = 'rotate(0deg)';
                 }
             }

             // Close dropdown when clicking outside
             document.addEventListener('click', function() {
                 if (isDropdownOpen) {
                     toggleDropdown();
                 }
             });

             // Handle sort option clicks
             document.querySelectorAll('.sort-option').forEach(button => {
                 button.addEventListener('click', function(e) {
                     e.stopPropagation();
                     const selectedSort = this.dataset.sort;
                     const option = sortOptions[selectedSort];
                     
                     // Update button appearance
                     sortIcon.className = option.icon + ' ' + option.color;
                     sortText.textContent = option.text;
                     
                     // Close dropdown
                     toggleDropdown();
                     
                     // Load downloads with new sort
                     loadUserDownloads(1, selectedSort);
                     
                     // Add loading state
                     dropdownButton.style.opacity = '0.7';
                     setTimeout(() => {
                         dropdownButton.style.opacity = '1';
                     }, 300);
                 });
             });
         });

         // Auto-Suggest Funktionalität für My Area Search
         let searchTimeout;
         let currentSearchTerm = '';
         
         document.addEventListener('DOMContentLoaded', function() {
             const myAreaSearchInput = document.getElementById('myAreaSearchInput');
             const myAreaSuggestions = document.getElementById('myAreaSuggestions');
             const clearSearchButton = document.getElementById('clearMyAreaSearch');
             
             if (myAreaSearchInput) {
                 // Input Event Listener
                 myAreaSearchInput.addEventListener('input', function(e) {
                     const query = e.target.value.trim();
                     currentSearchTerm = query;
                     
                     // Clear Button anzeigen/verstecken
                     if (query.length > 0) {
                         clearSearchButton.classList.remove('hidden');
                     } else {
                         clearSearchButton.classList.add('hidden');
                         hideSuggestions();
                         loadUserDownloads(1, currentSort); // Zeige alle Downloads wieder
                         return;
                     }
                     
                     // Debounce - warte 300ms nach letzter Eingabe
                     clearTimeout(searchTimeout);
                     searchTimeout = setTimeout(() => {
                         if (query.length >= 2) {
                             searchDownloads(query);
                         } else {
                             hideSuggestions();
                         }
                     }, 300);
                 });
                 
                 // Clear Button Funktionalität
                 clearSearchButton.addEventListener('click', function() {
                     myAreaSearchInput.value = '';
                     currentSearchTerm = '';
                     clearSearchButton.classList.add('hidden');
                     hideSuggestions();
                     loadUserDownloads(1, currentSort);
                 });
                 
                 // Escape Taste zum Schließen
                 myAreaSearchInput.addEventListener('keydown', function(e) {
                     if (e.key === 'Escape') {
                         hideSuggestions();
                         myAreaSearchInput.blur();
                     }
                 });
             }
             
             // Klick außerhalb schließt Suggestions
             document.addEventListener('click', function(e) {
                 if (!e.target.closest('#myAreaSearchContainer')) {
                     hideSuggestions();
                 }
             });
         });
         
         async function searchDownloads(query) {
             try {
                const normalizedQuery = normalizeGermanUmlauts(query);
                 const response = await fetch('/customdl/search_downloads.php', {
                     method: 'POST',
                     headers: {
                         'Content-Type': 'application/json',
                     },
                    body: JSON.stringify({ query: normalizedQuery })
                 });
                 
                 if (!response.ok) throw new Error('Search failed');
                 
                 const data = await response.json();
                 showSuggestions(data.suggestions);
                 
             } catch (error) {
                 console.error('Search error:', error);
                 hideSuggestions();
             }
         }
         
         function showSuggestions(suggestions) {
             const suggestionsContainer = document.getElementById('myAreaSuggestions');
             
             if (!suggestions || suggestions.length === 0) {
                 hideSuggestions();
                 return;
             }
             
             let html = '<div class="py-2">';
             
             suggestions.forEach(suggestion => {
                 html += `
                     <div class="suggestion-item flex items-center p-3 hover:bg-purple-500/10 cursor-pointer transition-all duration-200 group" 
                          onclick="selectSuggestion('${suggestion.folder_path}', '${suggestion.title.replace(/'/g, "\\'")}')">
                         <div class="flex-shrink-0 mr-3">
                             <img src="${suggestion.thumbnail}" 
                                  alt="${suggestion.title}" 
                                  class="w-12 h-12 rounded-lg object-cover border border-gray-600 group-hover:border-purple-500 transition-colors duration-200"
                                  onerror="this.onerror=null; this.src='/customdl/thumbnails/no-image.jpg';">
                         </div>
                         <div class="flex-1 min-w-0">
                             <div class="text-white font-medium truncate group-hover:text-purple-300 transition-colors duration-200">
                                 ${suggestion.title}
                             </div>
                             <div class="flex flex-wrap gap-1 mt-1">
                                 ${suggestion.tags.slice(0, 2).map(tag => {
                                     const tagClass = tag.toLowerCase().trim();
                                     return `<span class="tag ${tagClass} text-xs">${tag.trim()}</span>`;
                                 }).join('')}
                             </div>
                         </div>
                         <div class="flex-shrink-0 ml-2">
                             <i class="fas fa-arrow-right text-gray-400 group-hover:text-purple-400 transition-colors duration-200"></i>
                         </div>
                     </div>
                 `;
             });
             
             html += '</div>';
             
             suggestionsContainer.innerHTML = html;
             suggestionsContainer.classList.remove('hidden');
         }
         
         function hideSuggestions() {
             const suggestionsContainer = document.getElementById('myAreaSuggestions');
             suggestionsContainer.classList.add('hidden');
         }
         
         function selectSuggestion(folderPath, title) {
             // Verstecke Suggestions
             hideSuggestions();
             
             // Leere Suchfeld
             const myAreaSearchInput = document.getElementById('myAreaSearchInput');
             myAreaSearchInput.value = '';
             document.getElementById('clearMyAreaSearch').classList.add('hidden');
             
             // Öffne Download
             viewDownload(folderPath);
         }

        // Funktion um Wartungsmodus-Nachricht im Suggestions-Bereich anzuzeigen
        function displayMaintenanceMessage(message) {
            const suggestionsContainer = document.getElementById('suggestionsContainer');
            if (suggestionsContainer) {
                suggestionsContainer.innerHTML = `
                    <div class="search-container rounded-2xl p-8">
                        <div class="text-center">
                            <div class="relative mb-6">
                                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gradient-to-br from-red-500/20 to-orange-500/20 mb-4">
                                    <i class="fas fa-tools text-red-400 text-3xl"></i>
                                </div>
                            </div>
                            <h3 class="text-2xl font-bold text-white mb-4">Wartungsmodus</h3>
                            <p class="text-gray-300 mb-6">${message}</p>
                        </div>
                    </div>
                `;
            }
        }

         // Vorschläge-Funktionen
        let refreshTimer = null;

        async function loadSuggestions() {
            try {
                // Wartungsmodus-Prüfung für Vorschläge
                                
                const response = await fetch('/customdl/get_suggestions.php');
                const data = await response.json();
                
                if (data.success) {
                    displaySuggestions(data.suggestions, data.remaining, data.nextRefresh);
                    startRefreshTimer(data.nextRefresh);
                } else {
                    showNotification(data.message || 'Fehler beim Laden der Vorschläge', 'error');
                }
            } catch (error) {
                console.error('Error loading suggestions:', error);
                showNotification('Fehler beim Laden der Vorschläge', 'error');
            }
        }

        function displaySuggestions(suggestions, remaining, nextRefresh) {
            const suggestionsContent = document.getElementById('suggestionsContent');
            const suggestionsRemaining = document.getElementById('suggestionsRemaining');
            
            // Update remaining count
            suggestionsRemaining.textContent = remaining;
            
            if (!suggestions || suggestions.length === 0) {
                suggestionsContent.innerHTML = `
                    <div class="text-center py-12">
                        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gray-800 mb-6">
                            <i class="fas fa-magic text-3xl text-gray-400"></i>
                        </div>
                        <h3 class="text-2xl font-semibold text-white mb-4">Keine Vorschläge verfügbar</h3>
                        <p class="text-gray-400 max-w-md mx-auto leading-relaxed">
                            ${remaining === 0 ? 
                                'Du hast bereits alle deine täglichen Vorschläge verwendet. Komme morgen um 00:00 Uhr zurück für neue Vorschläge!' : 
                                'Sorry, für dich finden wir gerade keine passenden Vorschläge. Versuche es später erneut oder schaue dir deine eigenen Downloads an.'
                            }
                        </p>
                        ${remaining === 0 ? `
                            <div class="mt-6 bg-purple-500/10 border border-purple-500/20 rounded-xl p-4">
                                <p class="text-purple-200 text-sm">
                                    <i class="fas fa-clock mr-2"></i>
                                    Nächste Erneuerung: <span class="font-mono" id="noSuggestionsTimer">--:--:--</span>
                                </p>
                            </div>
                        ` : ''}
                    </div>
                `;
                return;
            }
            
            // Create suggestions grid
            const grid = document.createElement('div');
            grid.className = 'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6';
            
            suggestions.forEach(suggestion => {
                const card = document.createElement('div');
                card.className = 'result-card rounded-xl p-6 relative overflow-hidden';
                
                // Extract title from folder path
                const title = suggestion.folder_path.split('_').slice(1).join('_').replace(/_/g, ' ');
                
                // Image path
                let imagePath = '/customdl/thumbnails/no-image.jpg';
                if (suggestion.thumbnail_link) {
                    if (suggestion.thumbnail_link.startsWith('http')) {
                        imagePath = suggestion.thumbnail_link;
                    } else if (suggestion.thumbnail_link.startsWith('/customdl/thumbnails/')) {
                        imagePath = suggestion.thumbnail_link;
                    } else {
                        imagePath = '/customdl/thumbnails/' + suggestion.thumbnail_link;
                    }
                }
                
                card.innerHTML = `
                    <!-- Suggestion Badge -->
                    <div class="absolute top-3 left-3 z-10">
                        <div class="bg-gradient-to-r from-purple-500 to-pink-500 text-white px-3 py-1 rounded-full text-xs font-bold shadow-lg">
                            <i class="fas fa-magic mr-1"></i>Vorschlag
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="relative">
                            <img src="${imagePath}" 
                                 alt="${title}" 
                                 class="rounded-xl w-full h-48 object-cover"
                                 onerror="this.onerror=null; this.src='/customdl/thumbnails/no-image.jpg';" />
                            
                            <!-- Media Count Overlay -->
                            <div class="absolute bottom-2 right-2 bg-black bg-opacity-75 text-white px-2 py-1 rounded-lg text-sm">
                                <i class="fas fa-image mr-1"></i>${suggestion.images}
                                <i class="fas fa-video ml-2 mr-1"></i>${suggestion.videos}
                            </div>
                        </div>
                        
                        <h3 class="text-xl font-semibold text-white">${title}</h3>
                        
                        <div class="flex flex-wrap gap-2">
                            ${(() => {
                                const tags = suggestion.tags ? suggestion.tags.split(',') : ['OnlyFans'];
                                return tags.map(tag => {
                                    const tagClass = tag.toLowerCase().trim();
                                    return `<span class="tag ${tagClass}">${tag.trim()}</span>`;
                                }).join('');
                            })()}
                        </div>
                        
                        <!-- Suggestion Info -->
                        <div class="bg-purple-500/10 border border-purple-500/20 rounded-lg p-3">
                            <div class="flex items-center justify-between text-sm">
                                <div class="flex items-center text-purple-300">
                                    <i class="fas fa-star mr-2"></i>
                                    <span>Personalisierter Vorschlag</span>
                                </div>
                                <div class="flex items-center text-purple-300">
                                    <i class="fas fa-coins mr-1"></i>
                                    <span>1 Token</span>
                                </div>
                            </div>
                        </div>
                        
                        <button onclick="purchaseSuggestion('${suggestion.post_link}', '${title.replace(/'/g, "\\'")}', '${imagePath}', this)" 
                                data-tags='${JSON.stringify(suggestion.tags ? suggestion.tags.split(',') : [])}'
                                class="w-full px-6 py-3 bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 rounded-xl text-white font-semibold transition-all duration-300 flex items-center justify-center">
                            <i class="fas fa-magic mr-2"></i>
                            Vorschlag annehmen
                        </button>
                    </div>
                `;
                
                grid.appendChild(card);
            });
            
            suggestionsContent.innerHTML = '';
            suggestionsContent.appendChild(grid);
        }

        async function purchaseSuggestion(postLink, title, thumbnailLink, buttonElement) {
            // Prüfe ob genügend Tokens vorhanden sind
            const tokenCount = parseInt(document.getElementById('tokenCount').textContent);
            if (tokenCount < 1) {
                showNotification('Du benötigst 1 Token für diesen Vorschlag', 'error');
                showTokenPackages();
                return;
            }

            const tags = JSON.parse(buttonElement.getAttribute('data-tags') || '[]');

            try {
                const response = await fetch('/customdl/purchase_suggestion.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        postLink: postLink,
                        title: title,
                        thumbnailLink: thumbnailLink,
                        tags: tags
                    })
                });

                const data = await response.json();

                if (data.success) {
                    showNotification('Vorschlag erfolgreich hinzugefügt!', 'success');
                    // Aktualisiere Token-Anzeige
                    updateTokenDisplay(tokenCount - 1);
                    // Lade Vorschläge neu um Anzahl zu aktualisieren
                    loadSuggestions();
                } else {
                    showNotification(data.message || 'Fehler beim Hinzufügen des Vorschlags', 'error');
                }
            } catch (error) {
                console.error('Purchase Error:', error);
                showNotification('Fehler beim Hinzufügen des Vorschlags', 'error');
            }
        }

        function startRefreshTimer(nextRefresh) {
            // Clear existing timer
            if (refreshTimer) {
                clearInterval(refreshTimer);
            }
            
            function updateTimer() {
                const now = new Date();
                const refreshTime = new Date(nextRefresh);
                const timeDiff = refreshTime.getTime() - now.getTime();
                
                if (timeDiff <= 0) {
                    // Refresh time reached
                    document.getElementById('refreshCountdown').textContent = '00:00:00';
                    const noSuggestionsTimer = document.getElementById('noSuggestionsTimer');
                    if (noSuggestionsTimer) {
                        noSuggestionsTimer.textContent = '00:00:00';
                    }
                    // Reload suggestions if on suggestions tab
                    if (!suggestionsContainer.classList.contains('hidden')) {
                        loadSuggestions();
                    }
                    return;
                }
                
                const hours = Math.floor(timeDiff / (1000 * 60 * 60));
                const minutes = Math.floor((timeDiff % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((timeDiff % (1000 * 60)) / 1000);
                
                const timeString = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                
                document.getElementById('refreshCountdown').textContent = timeString;
                const noSuggestionsTimer = document.getElementById('noSuggestionsTimer');
                if (noSuggestionsTimer) {
                    noSuggestionsTimer.textContent = timeString;
                }
            }
            
            // Update immediately and then every second
            updateTimer();
            refreshTimer = setInterval(updateTimer, 1000);
        }

        // Bei Seitenladen prüfen, welcher Tab aktiv ist
         window.addEventListener('load', function() {
             // Standard: Such-Tab ist aktiv, also Such-Telegram-Box anzeigen falls vorhanden
             const telegramBoxSearch = document.getElementById('telegramBoxSearch');
             if (telegramBoxSearch) telegramBoxSearch.classList.remove('hidden');
             
             // Auto-Update der Zeitanzeigen alle 30 Sekunden (nur im "Eigener Bereich")
             setInterval(() => {
                 if (!myAreaContainer.classList.contains('hidden')) {
                     // Stille Aktualisierung der Downloads für Live-Zeitanzeigen
                     loadUserDownloads(1, currentSort);
                 }
             }, 30000); // 30 Sekunden
         });
    </script>
</body>
</html>

    </div> <!-- End main-content -->

    <footer class="footer flex justify-center items-center p-4 text-neutral-content mt-8 w-full">
        <div class="flex items-center space-x-4">
            <a class="text-lg font-bold text-white" href="/">🎀 • OFLeaks.tv</a>
            <span class="border-l border-gray-400 h-6 mx-2"></span>
            <a href="https://discord.celebroom.de" target="_blank" class="text-white hover:text-[#E638B5] transition-colors duration-300" aria-label="Discord">
                <i class="fab fa-discord fa-lg"></i>
                <span class="sr-only">Discord</span>
            </a>
            <a href="https://ofleaks.tv/shop" target="_blank" class="text-white hover:text-[#E638B5] transition-colors duration-300" aria-label="Shop">
                <i class="fa fa-shopping-cart fa-lg"></i>
                <span class="sr-only">Shop</span>
            </a>
        </div>
    </footer>

    <!-- Popup Include -->
    
    <script type="text/javascript" src="./assets/vendor/toastify/toastify.min.js"></script>
    <script src="./assets/vendor/flowbite/flowbite.min.js"></script>
    <script src="./assets/vendor/fancybox/fancybox.umd.js"></script>

<!-- Fancybox CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.css" />

<!-- lozad.js -->
<script src="https://cdn.jsdelivr.net/npm/lozad/dist/lozad.min.js"></script>
<!-- Fancybox JS -->
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.umd.js"></script>
<script>
    // Initialize lozad
    const observer = lozad(); // lazy loads elements with default selector as '.lozad'
    observer.observe();

    // Initialize Fancybox
    Fancybox.bind("[data-fancybox]", {
        // Globale Einstellungen
        Toolbar: {
            display: [
                "close",
                "prev",
                "next",
                "download",
                "fullscreen",
                "zoom",
                "slideshow",
                "thumbs"
            ],
        },
        // Spezifische Einstellungen für Videos
        Video: {
            autoStart: false, // Stelle sicher, dass Videos nicht automatisch starten
            preventCaptionOverlap: false,
            idleTime: false,
            clickToPlay: true,
            loop: false,
            // Weitere Video-spezifische Optionen
        },
    });
</script>                     
    <script src="./assets/js/main.js?v=1770765359"></script>

    <!-- Debug Flowbite Dropdowns -->
    <script>
        console.log('Checking Flowbite...');
        
        // Warte bis alles geladen ist
        window.addEventListener('load', function() {
            console.log('Page loaded, checking dropdowns...');
            
            // Finde alle dropdown toggles
            const dropdownToggles = document.querySelectorAll('[data-dropdown-toggle]');
            console.log('Found dropdown toggles:', dropdownToggles.length);
            
            dropdownToggles.forEach((toggle, index) => {
                const targetId = toggle.getAttribute('data-dropdown-toggle');
                const target = document.getElementById(targetId);
                console.log(`Dropdown ${index + 1}: Toggle found, Target ID: ${targetId}, Target exists:`, !!target);
            });
            
            // Prüfe ob Flowbite geladen ist
            console.log('Flowbite available:', typeof Flowbite !== 'undefined');
            console.log('initFlowbite available:', typeof initFlowbite !== 'undefined');
            
            // Force Flowbite init wenn verfügbar
            if (typeof initFlowbite !== 'undefined') {
                setTimeout(() => {
                    initFlowbite();
                    console.log('Flowbite manually initialized');
                }, 500);
            }
            
            // Z-Index Fix für geöffnete Dropdowns
            setTimeout(() => {
                const allDropdowns = document.querySelectorAll('[id^="mod-dropdown-"]');
                
                allDropdowns.forEach(dropdown => {
                    // MutationObserver um auf Klassen-Änderungen zu reagieren
                    const observer = new MutationObserver((mutations) => {
                        mutations.forEach((mutation) => {
                            if (mutation.attributeName === 'class') {
                                const postCard = dropdown.closest('.post-card');
                                if (postCard) {
                                    if (dropdown.classList.contains('hidden')) {
                                        // Dropdown geschlossen - normaler z-index
                                        postCard.style.zIndex = '1';
                                    } else {
                                        // Dropdown geöffnet - hoher z-index
                                        postCard.style.zIndex = '9998';
                                    }
                                }
                            }
                        });
                    });
                    
                    observer.observe(dropdown, { attributes: true });
                });
                
                console.log('Z-Index observers attached to', allDropdowns.length, 'dropdowns');
            }, 600);
        });
    </script>

</body>
</html>
 