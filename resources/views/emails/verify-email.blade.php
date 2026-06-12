<!DOCTYPE html>
<html lang="fr" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Activez votre compte StudyHub</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: #f1f5f9;
            color: #334155;
            -webkit-font-smoothing: antialiased;
        }
        .wrapper {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            padding: 32px 16px;
        }

        /* ── Header ── */
        .header {
            background: linear-gradient(135deg, #1e3a8a 0%, #1d4ed8 50%, #3b82f6 100%);
            border-radius: 20px 20px 0 0;
            padding: 40px 48px 36px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .header::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: radial-gradient(circle at 1px 1px, rgba(255,255,255,0.07) 1px, transparent 0);
            background-size: 28px 28px;
        }
        .header-logo {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            position: relative;
            z-index: 1;
            margin-bottom: 28px;
        }
        .logo-icon {
            width: 52px;
            height: 52px;
            background: rgba(255,255,255,0.15);
            border: 2px solid rgba(255,255,255,0.25);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }
        .logo-text {
            font-size: 28px;
            font-weight: 800;
            color: #ffffff;
            letter-spacing: -0.5px;
        }
        .header-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.25);
            border-radius: 50px;
            padding: 6px 16px;
            position: relative;
            z-index: 1;
            margin-bottom: 20px;
        }
        .badge-dot {
            width: 8px;
            height: 8px;
            background: #4ade80;
            border-radius: 50%;
        }
        .badge-text {
            font-size: 12px;
            font-weight: 600;
            color: rgba(255,255,255,0.9);
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        .header-title {
            font-size: 30px;
            font-weight: 800;
            color: #ffffff;
            line-height: 1.2;
            position: relative;
            z-index: 1;
        }
        .header-subtitle {
            font-size: 15px;
            color: rgba(255,255,255,0.75);
            margin-top: 10px;
            position: relative;
            z-index: 1;
        }

        /* ── Body ── */
        .body {
            background: #ffffff;
            padding: 40px 48px;
        }
        .greeting {
            font-size: 18px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 16px;
        }
        .text {
            font-size: 15px;
            color: #475569;
            line-height: 1.7;
            margin-bottom: 12px;
        }

        /* ── Étapes ── */
        .steps {
            background: #f8fafc;
            border-radius: 14px;
            padding: 24px 28px;
            margin: 28px 0;
            border: 1px solid #e2e8f0;
        }
        .steps-title {
            font-size: 13px;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            margin-bottom: 16px;
        }
        .step {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            margin-bottom: 14px;
        }
        .step:last-child { margin-bottom: 0; }
        .step-num {
            width: 28px;
            height: 28px;
            min-width: 28px;
            background: #dbeafe;
            color: #1d4ed8;
            border-radius: 50%;
            font-size: 13px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .step-text {
            font-size: 14px;
            color: #475569;
            line-height: 1.5;
            padding-top: 4px;
        }

        /* ── Bouton CTA ── */
        .cta-wrap {
            text-align: center;
            margin: 36px 0;
        }
        .cta-btn {
            display: inline-block;
            background: linear-gradient(135deg, #1d4ed8, #3b82f6);
            color: #ffffff !important;
            text-decoration: none;
            font-size: 16px;
            font-weight: 700;
            padding: 16px 42px;
            border-radius: 12px;
            letter-spacing: 0.3px;
            box-shadow: 0 8px 24px rgba(29, 78, 216, 0.35);
        }
        .cta-expiry {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 14px;
            font-size: 13px;
            color: #94a3b8;
        }
        .expiry-icon { font-size: 14px; }

        /* ── Divider ── */
        .divider {
            border: none;
            border-top: 1px solid #f1f5f9;
            margin: 32px 0;
        }

        /* ── Info card ── */
        .info-card {
            background: #fffbeb;
            border: 1px solid #fde68a;
            border-radius: 12px;
            padding: 16px 20px;
            display: flex;
            gap: 14px;
            margin-bottom: 28px;
        }
        .info-icon {
            font-size: 20px;
            flex-shrink: 0;
            margin-top: 1px;
        }
        .info-text {
            font-size: 13px;
            color: #92400e;
            line-height: 1.6;
        }
        .info-text strong {
            color: #78350f;
        }

        /* ── Lien de secours ── */
        .fallback {
            background: #f8fafc;
            border-radius: 10px;
            padding: 16px 20px;
            margin-bottom: 24px;
        }
        .fallback-label {
            font-size: 12px;
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }
        .fallback-url {
            font-size: 12px;
            color: #3b82f6;
            word-break: break-all;
            line-height: 1.6;
        }

        /* ── Footer ── */
        .footer {
            background: #1e293b;
            border-radius: 0 0 20px 20px;
            padding: 32px 48px;
            text-align: center;
        }
        .footer-logo {
            font-size: 18px;
            font-weight: 800;
            color: #ffffff;
            margin-bottom: 8px;
        }
        .footer-tagline {
            font-size: 13px;
            color: #94a3b8;
            margin-bottom: 20px;
        }
        .footer-links {
            margin-bottom: 20px;
        }
        .footer-links a {
            color: #64748b;
            text-decoration: none;
            font-size: 12px;
            margin: 0 10px;
        }
        .footer-copy {
            font-size: 12px;
            color: #475569;
        }
        .footer-security {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 50px;
            padding: 6px 14px;
            margin-bottom: 20px;
            font-size: 12px;
            color: #94a3b8;
        }

        @media (max-width: 480px) {
            .header, .body, .footer { padding-left: 24px; padding-right: 24px; }
            .header-title { font-size: 24px; }
            .cta-btn { padding: 14px 28px; font-size: 15px; }
        }
    </style>
</head>
<body>
<div class="wrapper">

    <!-- ── Header ── -->
    <div class="header">
        <div class="header-logo">
            <div class="logo-icon">🎓</div>
            <span class="logo-text">StudyHub</span>
        </div>
        <div class="header-badge">
            <div class="badge-dot"></div>
            <span class="badge-text">Activation de compte</span>
        </div>
        <div class="header-title">Confirmez votre adresse email</div>
        <div class="header-subtitle">Une dernière étape avant d'accéder à votre espace</div>
    </div>

    <!-- ── Body ── -->
    <div class="body">

        <p class="greeting">Bonjour {{ $user->name }} 👋</p>

        <p class="text">
            Merci de rejoindre <strong>StudyHub</strong> — la plateforme éducative complète pour
            réussir vos cours, épreuves et quiz en ligne.
        </p>
        <p class="text">
            Pour activer votre compte et accéder à toutes les fonctionnalités, cliquez sur le bouton
            ci-dessous pour confirmer votre adresse email.
        </p>

        <!-- Étapes -->
        <div class="steps">
            <div class="steps-title">Comment ça marche ?</div>
            <div class="step">
                <div class="step-num">1</div>
                <div class="step-text">Cliquez sur le bouton <strong>« Activer mon compte »</strong> ci-dessous</div>
            </div>
            <div class="step">
                <div class="step-num">2</div>
                <div class="step-text">Vous serez redirigé vers StudyHub et connecté automatiquement</div>
            </div>
            <div class="step">
                <div class="step-num">3</div>
                <div class="step-text">Accédez à vos cours, épreuves et quiz — bonne réussite !</div>
            </div>
        </div>

        <!-- Bouton CTA -->
        <div class="cta-wrap">
            <a href="{{ $verificationUrl }}" class="cta-btn">
                ✅ &nbsp; Activer mon compte
            </a>
            <div class="cta-expiry">
                <span class="expiry-icon">⏱</span>
                Ce lien expire dans <strong>&nbsp;60 minutes</strong>
            </div>
        </div>

        <hr class="divider">

        <!-- Avertissement si non concerné -->
        <div class="info-card">
            <div class="info-icon">⚠️</div>
            <div class="info-text">
                <strong>Vous n'avez pas créé de compte ?</strong><br>
                Ignorez simplement cet email. Aucune action de votre part n'est requise et votre adresse
                ne sera pas utilisée.
            </div>
        </div>

        <!-- Lien de secours -->
        <div class="fallback">
            <div class="fallback-label">Si le bouton ne fonctionne pas, copiez ce lien dans votre navigateur :</div>
            <div class="fallback-url">{{ $verificationUrl }}</div>
        </div>

        <p class="text" style="font-size:14px; color:#94a3b8;">
            Cet email vous a été envoyé car un compte StudyHub a été créé avec cette adresse email.
        </p>

    </div>

    <!-- ── Footer ── -->
    <div class="footer">
        <div class="footer-security">
            🔒 &nbsp; Email sécurisé — nous ne partageons jamais vos données
        </div>
        <div class="footer-logo">StudyHub</div>
        <div class="footer-tagline">Votre réussite commence ici.</div>
        <div class="footer-links">
            <a href="{{ url('/') }}">Accueil</a>
            <a href="{{ url('/cours') }}">Cours</a>
            <a href="{{ url('/epreuves') }}">Épreuves</a>
            <a href="{{ url('/assistance') }}">Assistance</a>
        </div>
        <div class="footer-copy">
            &copy; {{ date('Y') }} StudyHub. Tous droits réservés.
        </div>
    </div>

</div>
</body>
</html>
