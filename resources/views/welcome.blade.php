<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="VacciBuddy - Your intelligent vaccination management system">
    <title>VacciBuddy - Your Vaccination Companion</title>
    <link rel="stylesheet" href="{{ asset('site/css/style.css') }}">
</head>

<body>
    <main class="main">
        
        <!-- Hero Section -->
        <section class="hero">
            <div class="floating-icons" aria-hidden="true"></div>
            <h1>Never Miss a Vaccination!<br>with VacciBuddy</h1>
            <p>Take control of your health journey with our intelligent vaccination management system. Never miss an
                important shot again.</p>
            <div class="hero-buttons">
                <a class="cta-button" href="{{route('dashboard')}}" style="text-decoration:none">Make me healthier</a>
            </div>
            <p class="privacy-note">
                <span aria-hidden="true">🔒</span>
                <span>Your information is private and secure</span>
            </p>
        </section>

        <!-- Benefits Section -->
        <section class="benefits-section">
            <h2 class="section-title">Benefits You Can Expect</h2>
            <div class="key-benefits">
                <article class="benefit-card">
                    <h3>Effortless Protection</h3>
                    <p>Stay informed and protected without lifting a finger</p>
                </article>
                <article class="benefit-card">
                    <h3>Time-Saving Solutions</h3>
                    <p>Simple appointment bookings and on-the-go access to your records</p>
                </article>
                <article class="benefit-card">
                    <h3>Complete Compliance</h3>
                    <p>Early alerts ensure compliance with national vaccine programs</p>
                </article>
            </div>
        </section>

        <!-- How It Works Section -->
        <section class="how-it-works-section">
            <h2 class="section-title">How It Works</h2>
            <div class="steps">
                <article class="step-card">
                    <div class="step-number" aria-label="Step 1">1</div>
                    <div class="step-content">
                        <h3>Create Your Profile</h3>
                        <p>Sign up and enter your basic health information and vaccination history. Our secure platform
                            ensures your data is protected.</p>
                    </div>
                </article>
                <article class="step-card">
                    <div class="step-number" aria-label="Step 2">2</div>
                    <div class="step-content">
                        <h3>Set Your Schedule</h3>
                        <p>Get a personalized vaccination schedule based on your age and health status.</p>
                    </div>
                </article>
                <article class="step-card">
                    <div class="step-number" aria-label="Step 3">3</div>
                    <div class="step-content">
                        <h3>Get Notified</h3>
                        <p>Receive timely reminders for upcoming vaccinations and boosters. Never miss an important shot
                            again.</p>
                    </div>
                </article>
                <article class="step-card">
                    <div class="step-number" aria-label="Step 4">4</div>
                    <div class="step-content">
                        <h3>Schedule Appointments</h3>
                        <p>Receive reminders for vaccination and boosters to make your scheduling simple.</p>
                    </div>
                </article>
                <article class="step-card">
                    <div class="step-number" aria-label="Step 5">5</div>
                    <div class="step-content">
                        <h3>Track Progress</h3>
                        <p>Monitor your vaccination status and maintain digital records. Access your history anytime,
                            anywhere.</p>
                    </div>
                </article>
            </div>
        </section>

        <!-- Features Section -->
        <section class="features-section">
            <h2 class="section-title">Key Features</h2>
            <div class="features">
                <article class="feature-card">
                    <div class="feature-icon" aria-hidden="true">📊</div>
                    <h3>Progress Tracker</h3>
                    <p>Monitor your vaccination history</p>
                </article>
                <article class="feature-card">
                    <div class="feature-icon" aria-hidden="true">🔔</div>
                    <h3>Smart Reminders</h3>
                    <p>Never miss a vaccination date</p>
                </article>
                <article class="feature-card">
                    <div class="feature-icon" aria-hidden="true">✈️</div>
                    <h3>Vaccine passport</h3>
                    <p>Access your records anywhere</p>
                </article>
            </div>
        </section>
    </main>

    <footer class="footer">
        <p>
            Made with
            <span class="animated-icon" aria-hidden="true">❤️</span>
            <span class="animated-icon" aria-hidden="true">☕️</span>
            <span class="animated-icon" aria-hidden="true">💪</span>
            <span class="animated-icon" aria-hidden="true">🧠</span>
            for public health
        </p>
    </footer>

    <script src="{{ asset('site/js/main.js') }}"></script>
</body>

</html>
