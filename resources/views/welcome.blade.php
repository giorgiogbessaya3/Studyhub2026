@extends('layouts.app')

@section('title', 'Accueil - Kounde Avocats')

@section('content')

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <title>Kounde Avocats | Expertise Juridique à Toulouse</title>
    <style>
        :root {
            --orange: #ff8c00;
            --orange-light: #ffb347;
            --dark-blue: #1a2942;
            --light-bg: #f5f5f0;
            --text-dark: #333;
            --text-light: #fff;
            --text-gray: #666;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: var(--text-dark);
            overflow-x: hidden;
            padding-top: 80px;
        }

        .btn-orange {
            background: linear-gradient(135deg, var(--orange), var(--orange-light));
            color: white;
            padding: 14px 30px;
            font-size: 14px;
            font-weight: 600;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            display: inline-flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            box-shadow: 0 4px 15px rgba(255, 140, 0, 0.3);
            position: relative;
            overflow: hidden;
        }

        .btn-orange::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: all 0.5s ease;
        }

        .btn-orange:hover::before {
            width: 300px;
            height: 300px;
        }

        .btn-orange:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(255, 140, 0, 0.5);
            color: white;
        }

        .btn-orange i {
            position: relative;
            z-index: 1;
            transition: transform 0.3s ease;
        }

        .btn-orange:hover i {
            transform: translateX(5px);
        }

        .btn-white {
            background-color: transparent;
            color: white;
            padding: 14px 30px;
            font-size: 14px;
            font-weight: 600;
            border: 2px solid white;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .btn-white:hover {
            background-color: rgba(255, 255, 255, 0.15);
            transform: translateY(-2px);
            color: white;
            box-shadow: 0 5px 20px rgba(255, 255, 255, 0.2);
        }

        .hero-section {
            background: linear-gradient(135deg, var(--dark-blue) 0%, #2d4a6b 100%);
            padding: 80px 60px;
            display: flex;
            align-items: center;
            gap: 60px;
            min-height: 90vh;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><circle cx="50" cy="50" r="2" fill="rgba(255,140,0,0.1)"/></svg>');
            opacity: 0.3;
        }

        .hero-content {
            flex: 1;
            max-width: 600px;
            position: relative;
            z-index: 1;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: rgba(255, 140, 0, 0.2);
            backdrop-filter: blur(10px);
            padding: 10px 20px;
            border-radius: 25px;
            margin-bottom: 25px;
            font-size: 14px;
            color: white;
            border: 1px solid rgba(255, 140, 0, 0.3);
        }

        .hero-badge i {
            color: var(--orange);
            font-size: 18px;
        }

        .hero-title {
            background: linear-gradient(135deg, var(--orange), var(--orange-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 56px;
            font-weight: bold;
            margin-bottom: 20px;
            line-height: 1.2;
        }

        .hero-subtitle {
            color: white;
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 25px;
            line-height: 1.4;
        }

        .hero-description {
            color: #c5d1e0;
            font-size: 16px;
            line-height: 1.8;
            margin-bottom: 35px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .hero-description i {
            color: var(--orange);
            font-size: 20px;
            margin-top: 3px;
        }

        .hero-buttons {
            display: flex;
            gap: 15px;
            margin-bottom: 40px;
            flex-wrap: wrap;
        }

        .hero-features {
            display: flex;
            gap: 25px;
            flex-wrap: wrap;
        }

        .hero-feature {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            color: #c5d1e0;
            padding: 8px 15px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 20px;
            backdrop-filter: blur(5px);
        }

        .hero-feature i {
            color: var(--orange);
            font-size: 16px;
        }

        .hero-image {
            flex: 1;
            max-width: 500px;
            position: relative;
            z-index: 1;
        }

        .image-frame {
            position: relative;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
            transition: transform 0.3s ease;
        }

        .image-frame:hover {
            transform: translateY(-10px);
        }

        .hero-image img {
            width: 100%;
            height: auto;
            border-radius: 15px;
            display: block;
        }

        .image-badge {
            position: absolute;
            top: 25px;
            right: 25px;
            background: linear-gradient(135deg, var(--orange), var(--orange-light));
            color: white;
            padding: 12px 20px;
            border-radius: 25px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            font-weight: 700;
            box-shadow: 0 5px 20px rgba(255, 140, 0, 0.4);
        }

        .about-section {
            background-color: var(--light-bg);
            padding: 100px 60px;
        }

        .about-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            gap: 80px;
            align-items: center;
        }

        .about-image-wrapper {
            position: relative;
            flex: 1;
        }

        .image-container {
            position: relative;
        }

        .about-image {
            width: 100%;
            max-width: 450px;
            height: auto;
            border-radius: 15px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
            transition: transform 0.3s ease;
        }

        .about-image:hover {
            transform: scale(1.02);
        }

        .experience-badge {
            position: absolute;
            top: 20px;
            right: -30px;
            width: 150px;
            height: 150px;
        }

        .badge-content {
            width: 100%;
            height: 100%;
            background: white;
            border-radius: 50%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 40px rgba(255, 140, 0, 0.3);
            border: 4px solid var(--orange);
            text-align: center;
            padding: 15px;
        }

        .badge-content i {
            color: var(--orange);
            font-size: 30px;
            margin-bottom: 8px;
        }

        .badge-text {
            color: var(--orange);
            font-size: 14px;
            font-weight: bold;
            line-height: 1.3;
        }

        .about-content {
            flex: 1;
        }

        .about-label {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--orange);
            font-size: 15px;
            font-weight: 600;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .label-icon {
            font-size: 18px;
        }

        .about-title {
            font-size: 42px;
            color: var(--dark-blue);
            font-weight: bold;
            line-height: 1.3;
            margin-bottom: 25px;
        }

        .text-orange {
            background: linear-gradient(135deg, var(--orange), var(--orange-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .about-description {
            color: var(--text-gray);
            font-size: 16px;
            line-height: 1.8;
            margin-bottom: 35px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .about-description i {
            color: var(--orange);
            font-size: 20px;
            margin-top: 3px;
        }

        .about-features {
            display: flex;
            flex-direction: column;
            gap: 20px;
            margin-bottom: 35px;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 20px;
            padding: 20px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }

        .feature-item:hover {
            transform: translateX(10px);
            box-shadow: 0 8px 25px rgba(255, 140, 0, 0.2);
        }

        .feature-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #fff0e0, #ffe0c0);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .feature-icon i {
            color: var(--orange);
            font-size: 22px;
        }

        .feature-content {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .feature-number {
            color: var(--orange);
            font-size: 16px;
            font-weight: bold;
        }

        .feature-text {
            color: var(--dark-blue);
            font-size: 17px;
            font-weight: 600;
        }

        .stats-section {
            background: linear-gradient(135deg, var(--dark-blue), #2d4a6b);
            padding: 80px 60px;
        }

        .stats-container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 40px;
        }

        .stat-item {
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
            padding: 30px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .stat-item:hover {
            transform: translateY(-10px);
            background: rgba(255, 140, 0, 0.15);
            border-color: var(--orange);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--orange), var(--orange-light));
            border-radius: 50%;
            box-shadow: 0 5px 20px rgba(255, 140, 0, 0.3);
        }

        .stat-icon i {
            font-size: 30px;
            color: white;
        }

        .stat-number {
            font-size: 48px;
            font-weight: bold;
            color: white;
        }

        .stat-label {
            font-size: 15px;
            color: rgba(255, 255, 255, 0.8);
            font-weight: 500;
        }

        .expertise-section {
            background-color: var(--light-bg);
            padding: 100px 60px;
        }

        .expertise-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .expertise-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 60px;
            flex-wrap: wrap;
            gap: 30px;
        }

        .expertise-title-group {
            flex: 1;
        }

        .expertise-label {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--orange);
            font-size: 15px;
            font-weight: 600;
            margin-bottom: 15px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .expertise-title {
            font-size: 42px;
            font-weight: 700;
            color: var(--dark-blue);
            line-height: 1.2;
        }

        .expertise-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 25px;
        }

        .expertise-card {
            position: relative;
            border-radius: 15px;
            overflow: hidden;
            height: 450px;
            cursor: pointer;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .expertise-card:hover {
            transform: translateY(-15px);
            box-shadow: 0 20px 50px rgba(255, 140, 0, 0.3);
        }

        .card-icon {
            position: absolute;
            top: 25px;
            left: 25px;
            background: linear-gradient(135deg, var(--orange), var(--orange-light));
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2;
            box-shadow: 0 5px 20px rgba(255, 140, 0, 0.4);
            transition: all 0.3s ease;
        }

        .expertise-card:hover .card-icon {
            transform: rotate(360deg) scale(1.1);
        }

        .card-icon i {
            color: white;
            font-size: 24px;
        }

        .expertise-card .card-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: brightness(0.7);
            transition: all 0.4s ease;
        }

        .expertise-card:hover .card-image {
            transform: scale(1.1);
            filter: brightness(0.9);
        }

        .card-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            padding: 25px;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.9) 0%, rgba(0, 0, 0, 0.3) 100%);
            color: white;
            text-align: center;
            border-top: 4px solid var(--orange);
            transition: all 0.3s ease;
        }

        .expertise-card:hover .card-overlay {
            padding: 30px;
        }

        .card-text {
            font-size: 20px;
            font-weight: bold;
            display: block;
            margin-bottom: 8px;
        }

        .card-description {
            font-size: 13px;
            opacity: 0.9;
            line-height: 1.5;
        }

        .whyme-section {
            background-color: white;
            padding: 100px 60px;
        }

        .whyme-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .whyme-header-content {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 60px;
            gap: 30px;
            flex-wrap: wrap;
        }

        .whyme-title-group {
            flex: 1;
        }

        .whyme-label {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--orange);
            font-size: 15px;
            font-weight: 600;
            margin-bottom: 15px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .whyme-main-title {
            font-size: 42px;
            font-weight: bold;
            color: var(--dark-blue);
            line-height: 1.2;
        }

        .whyme-main-content {
            display: flex;
            gap: 50px;
            align-items: flex-start;
        }

        .whyme-image-col {
            flex: 1;
            min-width: 40%;
        }

        .image-wrapper {
            position: relative;
        }

        .whyme-image {
            width: 100%;
            height: auto;
            max-height: 500px;
            object-fit: cover;
            border-radius: 15px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .floating-testimonial {
            position: absolute;
            bottom: -30px;
            right: -30px;
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
            max-width: 220px;
        }

        .testimonial-content i {
            color: var(--orange);
            font-size: 24px;
            margin-bottom: 12px;
        }

        .testimonial-content p {
            font-size: 14px;
            line-height: 1.6;
            color: var(--text-gray);
            margin: 0;
        }

        .client-info {
            margin-top: 12px;
            padding-top: 12px;
            border-top: 1px solid #eee;
            font-size: 13px;
        }

        .client-info strong {
            display: block;
            color: var(--dark-blue);
            margin-bottom: 3px;
        }

        .client-info span {
            color: var(--text-gray);
        }

        .whyme-features-grid {
            flex: 1.5;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 25px;
        }

        .whyme-feature-card {
            background-color: #fcfcfc;
            padding: 35px;
            border-radius: 15px;
            border: 1px solid #f0f0f0;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .whyme-feature-card:hover {
            box-shadow: 0 10px 30px rgba(255, 140, 0, 0.15);
            border-color: var(--orange);
            transform: translateY(-5px);
        }

        .feature-icon-wrapper {
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #fff0e0, #ffe0c0);
            border-radius: 50%;
            margin-bottom: 20px;
            border: 2px solid var(--orange);
        }

        .feature-icon {
            font-size: 22px;
            color: var(--orange);
        }

        .feature-title {
            font-size: 19px;
            font-weight: bold;
            color: var(--dark-blue);
            margin-bottom: 12px;
        }

        .feature-description {
            font-size: 15px;
            color: var(--text-gray);
            line-height: 1.7;
        }

        .process-section {
            background: linear-gradient(135deg, var(--dark-blue), #2d4a6b);
            padding: 100px 60px;
            position: relative;
            overflow: hidden;
        }

        .process-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><circle cx="50" cy="50" r="2" fill="rgba(255,140,0,0.1)"/></svg>');
            opacity: 0.3;
        }

        .process-container {
            max-width: 1200px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        .process-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 70px;
            gap: 30px;
            flex-wrap: wrap;
        }

        .process-title-group {
            flex: 1;
        }

        .process-label {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--orange);
            font-size: 15px;
            font-weight: 600;
            margin-bottom: 15px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .process-main-title {
            font-size: 42px;
            font-weight: bold;
            color: white;
            line-height: 1.2;
        }

        .process-main-content {
            display: flex;
            gap: 70px;
            align-items: flex-start;
        }

        .process-steps {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 40px;
            max-width: 500px;
        }

        .process-step-item {
            display: flex;
            gap: 25px;
            align-items: flex-start;
            padding: 25px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .process-step-item:hover {
            background: rgba(255, 140, 0, 0.15);
            transform: translateX(10px);
            border-color: var(--orange);
        }

        .step-number {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, var(--orange), var(--orange-light));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 28px;
            box-shadow: 0 5px 20px rgba(255, 140, 0, 0.4);
            flex-shrink: 0;
        }

        .step-content {
            flex: 1;
        }

        .step-title {
            font-size: 21px;
            font-weight: bold;
            color: white;
            margin-bottom: 10px;
        }

        .step-description {
            font-size: 15px;
            color: rgba(255, 255, 255, 0.8);
            line-height: 1.7;
        }

        .process-image-col {
            flex: 1.5;
            position: relative;
            max-width: 600px;
        }

        .process-image {
            width: 100%;
            height: auto;
            max-height: 700px;
            object-fit: cover;
            border-radius: 15px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .process-stats-bar {
            position: absolute;
            top: 0;
            left: 0;
            background: linear-gradient(135deg, var(--orange), var(--orange-light));
            color: white;
            display: flex;
            width: calc(100% / 2 + 10px);
            z-index: 10;
            border-radius: 15px 0 15px 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(255, 140, 0, 0.4);
        }

        .stat-box {
            flex: 1;
            padding: 25px 20px;
            text-align: center;
        }

        .stat-box:first-child {
            background: rgba(0, 0, 0, 0.1);
        }

        .stat-value {
            display: block;
            font-size: 32px;
            font-weight: bold;
            line-height: 1.2;
        }

        .stat-box .stat-label {
            display: block;
            font-size: 12px;
            margin-top: 8px;
            line-height: 1.2;
            opacity: 0.9;
            color: white;
        }

        /* Blog Section Styles - Updated to match blog page */
        .blog-section {
            background-color: white;
            padding: 100px 60px;
        }

        .blog-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .blog-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 60px;
            gap: 30px;
            flex-wrap: wrap;
        }

        .blog-title-group {
            max-width: 600px;
        }

        .blog-label {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--orange);
            font-size: 15px;
            font-weight: 600;
            margin-bottom: 15px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .blog-main-title {
            font-size: 40px;
            font-weight: 700;
            color: var(--dark-blue);
            line-height: 1.2;
        }

        .highlight-orange {
            background: linear-gradient(135deg, var(--orange), var(--orange-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .blog-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
        }

        .blog-post-card {
            display: block;
            position: relative;
            border-radius: 12px;
            overflow: hidden;
            height: 380px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            text-decoration: none;
            transition: all 0.4s ease;
            background: white;
            cursor: pointer;
        }

        .blog-post-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }

        .post-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .blog-post-card:hover .post-image {
            transform: scale(1.05);
        }

        .post-content-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.9) 0%, rgba(0, 0, 0, 0) 100%);
            padding: 25px 20px 20px;
            color: white;
            z-index: 3;
        }

        .post-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 15px;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .post-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.9);
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .meta-item i {
            color: #ff8c00;
            font-size: 0.9rem;
        }

        .post-category {
            position: absolute;
            top: 15px;
            left: 15px;
            background: #ff8c00;
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            z-index: 4;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .video-category {
            background: #ff0000 !important;
        }

        /* Styles pour la vidéo YouTube */
        .video-container {
            position: relative;
            width: 100%;
            height: 100%;
            background: #000;
        }

        .youtube-embed {
            width: 100%;
            height: 100%;
            border: none;
        }

        .video-thumbnail {
            width: 100%;
            height: 100%;
            object-fit: cover;
            cursor: pointer;
            transition: opacity 0.3s ease;
        }

        .video-play-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background 0.3s ease;
            z-index: 2;
        }

        .video-play-overlay:hover {
            background: rgba(0, 0, 0, 0.5);
        }

        .play-button {
            width: 80px;
            height: 80px;
            background: #ff0000;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
            transition: transform 0.3s ease;
        }

        .video-play-overlay:hover .play-button {
            transform: scale(1.1);
        }

        .video-playing .video-thumbnail,
        .video-playing .video-play-overlay {
            display: none;
        }

        /* Image par défaut */
        .default-blog-image {
            background: linear-gradient(135deg, var(--dark-blue), #2d4a6b);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 3rem;
        }

        /* Animation des cartes */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .blog-post-card {
            animation: fadeInUp 0.6s ease forwards;
        }

        .blog-post-card:nth-child(1) { animation-delay: 0.1s; }
        .blog-post-card:nth-child(2) { animation-delay: 0.2s; }
        .blog-post-card:nth-child(3) { animation-delay: 0.3s; }

        /* Styles pour le modal */
        .blog-modal .modal-content {
            border-radius: 15px;
            border: none;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .blog-modal .modal-header {
            background: linear-gradient(135deg, var(--dark-blue), #2d4a6b);
            color: white;
            border-bottom: none;
            border-radius: 15px 15px 0 0;
            padding: 25px 30px;
        }

        .blog-modal .modal-title {
            font-size: 1.5rem;
            font-weight: 700;
        }

        .blog-modal .btn-close {
            filter: invert(1);
            opacity: 0.8;
        }

        .blog-modal .modal-body {
            padding: 30px;
            max-height: 70vh;
            overflow-y: auto;
        }

        .blog-modal .blog-meta {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e9ecef;
        }

        .blog-modal .blog-meta-item {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #6c757d;
            font-size: 0.9rem;
        }

        .blog-modal .blog-meta-item i {
            color: #ff8c00;
        }

        .blog-modal .blog-description {
            font-size: 1.1rem;
            color: #495057;
            line-height: 1.6;
            margin-bottom: 20px;
            font-style: italic;
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #ff8c00;
        }

        .blog-modal .blog-content {
            color: #333;
            line-height: 1.8;
            font-size: 1rem;
        }

        .blog-modal .blog-content img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin: 15px 0;
        }

        .blog-modal .modal-footer {
            border-top: 1px solid #e9ecef;
            padding: 20px 30px;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .hero-section,
            .about-section,
            .stats-section,
            .expertise-section,
            .whyme-section,
            .process-section,
            .blog-section {
                padding: 60px 30px;
            }
            
            .stats-container,
            .expertise-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .blog-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .expertise-header {
                flex-direction: column;
                align-items: flex-start;
                margin-bottom: 40px;
            }
            
            .expertise-title {
                font-size: 32px;
                margin-top: 10px;
                margin-bottom: 20px;
            }
            
            .whyme-main-content {
                flex-direction: column;
                gap: 30px;
            }
            
            .whyme-image-col {
                min-width: 100%;
            }
            
            .whyme-features-grid {
                grid-template-columns: 1fr;
            }
            
            .process-header {
                flex-direction: column;
                align-items: flex-start;
                margin-bottom: 40px;
            }
            
            .process-main-content {
                flex-direction: column-reverse;
                gap: 40px;
            }
            
            .process-image-col {
                width: 100%;
                max-width: none;
            }
            
            .process-stats-bar {
                width: 100%;
                position: static;
                border-radius: 15px 15px 0 0;
            }

            .blog-modal .modal-body {
                padding: 25px;
                max-height: 60vh;
            }

            .blog-modal .modal-header {
                padding: 20px;
            }
        }

        @media (max-width: 768px) {
            body {
                padding-top: 70px;
            }

            .hero-section,
            .about-section,
            .stats-section,
            .expertise-section,
            .whyme-section,
            .process-section,
            .blog-section {
                padding: 50px 20px;
            }
            
            .hero-section {
                flex-direction: column;
                text-align: center;
                gap: 40px;
                min-height: auto;
            }
            
            .about-container {
                flex-direction: column;
                gap: 40px;
            }
            
            .stats-container,
            .expertise-grid,
            .blog-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            
            .expertise-card,
            .blog-post-card {
                height: 350px;
            }
            
            .hero-title {
                font-size: 38px;
            }
            
            .hero-subtitle {
                font-size: 20px;
            }
            
            .about-title,
            .expertise-title,
            .whyme-main-title,
            .process-main-title,
            .blog-main-title {
                font-size: 32px;
            }
            
            .hero-buttons {
                flex-direction: column;
                align-items: center;
                width: 100%;
            }
            
            .btn-orange,
            .btn-white {
                width: 100%;
                max-width: 300px;
                justify-content: center;
            }
            
            .whyme-header-content {
                flex-direction: column;
                align-items: flex-start;
                margin-bottom: 30px;
            }
            
            .whyme-main-title {
                margin-bottom: 20px;
            }
            
            .process-step-item {
                gap: 15px;
            }
            
            .stat-box {
                padding: 20px 15px;
            }
            
            .stat-value {
                font-size: 28px;
            }
            
            .blog-header {
                flex-direction: column;
                align-items: flex-start;
                margin-bottom: 30px;
            }
            
            .experience-badge {
                position: relative;
                top: 0;
                right: 0;
                margin: 20px auto;
            }
            
            .floating-testimonial {
                position: relative;
                right: 0;
                bottom: 0;
                max-width: 100%;
                margin-top: 20px;
            }
            
            .play-button {
                width: 60px;
                height: 60px;
                font-size: 1.5rem;
            }

            .blog-modal .blog-meta {
                flex-direction: column;
                gap: 12px;
            }

            .hero-image {
                max-width: 100%;
            }

            .process-image-col {
                max-width: 100%;
            }
        }

        @media (max-width: 576px) {
            .hero-title {
                font-size: 32px;
            }

            .about-title,
            .expertise-title,
            .whyme-main-title,
            .process-main-title,
            .blog-main-title {
                font-size: 28px;
            }

            .stat-number {
                font-size: 36px;
            }

            .expertise-card,
            .blog-post-card {
                height: 300px;
            }
        }
    </style>
</head>
<body>
    <section class="hero-section" id="accueil">
        <div class="hero-content">
            <div class="hero-badge">
                <i class="fas fa-award"></i> 
                <span>Expertise reconnue depuis 20 ans</span>
            </div>
            <h1 class="hero-title">Maître Koundé,</h1>
            <h2 class="hero-subtitle">Votre Avocat en Droit Immobilier, Bancaire et de la Construction à Toulouse</h2>
            <p class="hero-description">
                <i class="fas fa-shield-alt"></i> 
                <span>Fort de plus de 20 ans d'expérience, Maître Koundé défend, conseille et vous accompagne avec détermination pour sécuriser vos intérêts et résoudre vos litiges avec efficacité.</span>
            </p>
            <div class="hero-buttons">
                <button class="btn-orange" id="rdv-btn">
                    <i class="fas fa-calendar-check"></i> 
                    <span>Prendre RDV</span>
                </button>
                <button class="btn-white" id="call-btn">
                    <i class="fas fa-phone"></i> 
                    <span>Appeler le cabinet</span>
                </button>
            </div>
            
            <div class="hero-features">
                <div class="hero-feature">
                    <i class="fas fa-check-circle"></i>
                    <span>Consultation personnalisée</span>
                </div>
                <div class="hero-feature">
                    <i class="fas fa-check-circle"></i>
                    <span>Accompagnement sur mesure</span>
                </div>
                <div class="hero-feature">
                    <i class="fas fa-check-circle"></i>
                    <span>Expertise multidisciplinaire</span>
                </div>
            </div>
        </div>

        <div class="hero-image">
            <div class="image-frame">
                <img src="{{ asset('img/im.png') }}" alt="Maître Koundé" onerror="this.src='https://images.unsplash.com/photo-1589829545856-d10d557cf95f?w=800'">
                <div class="image-badge">
                    <i class="fas fa-star"></i>
                    <span>20+ ans d'expérience</span>
                </div>
            </div>
        </div>
    </section>

    <section class="about-section" id="apropos">
        <div class="about-container">
            <div class="about-image-wrapper">
                <div class="image-container">
                    <img src="{{ asset('img/ima.png') }}" alt="Expert juridique" class="about-image" onerror="this.src='https://images.unsplash.com/photo-1556157382-97eda2f9e2bf?w=600'">
                    <div class="experience-badge">
                        <div class="badge-content">
                            <i class="fas fa-trophy"></i>
                            <span class="badge-text">+20 ans<br>d'expérience</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="about-content">
                <div class="about-label">
                    <span class="label-icon"><i class="fas fa-rocket"></i></span>
                    <span>À propos de votre avocat</span>
                </div>
                <h2 class="about-title">
                    Un expert juridique <span class="text-orange">engagé</span> à défendre vos intérêts
                </h2>
                <p class="about-description">
                    <i class="fas fa-quote-left"></i> 
                    <span>Reconnu pour sa rigueur et son accompagnement personnalisé, Maître Koundé met son expertise au service de vos droits avec détermination, écoute et efficacité dans les domaines immobilier, bancaire et de la construction.</span>
                </p>
                
                <div class="about-features">
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <div class="feature-content">
                            <span class="feature-number">01</span>
                            <span class="feature-text">Une expertise légale éprouvée et reconnue</span>
                        </div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-heart"></i>
                        </div>
                        <div class="feature-content">
                            <span class="feature-number">02</span>
                            <span class="feature-text">Des centaines de clients satisfaits et accompagnés</span>
                        </div>
                    </div>
                </div>

                <button class="btn-orange" id="about-btn">
                    <i class="fas fa-book-open"></i> 
                    <span>Découvrir mon parcours</span>
                </button>
            </div>
        </div>
    </section>

    <section class="stats-section">
        <div class="stats-container">
            <div class="stat-item">
                <div class="stat-icon">
                    <i class="fas fa-folder-open"></i>
                </div>
                <div class="stat-number" data-count="500">0</div>
                <div class="stat-label">Dossiers Plaidés</div>
            </div>

            <div class="stat-item">
                <div class="stat-icon">
                    <i class="fas fa-user-friends"></i>
                </div>
                <div class="stat-number" data-count="1000">0</div>
                <div class="stat-label">Clients accompagnés</div>
            </div>

            <div class="stat-item">
                <div class="stat-icon">
                    <i class="fas fa-business-time"></i>
                </div>
                <div class="stat-number" data-count="20">0</div>
                <div class="stat-label">Ans d'expérience</div>
            </div>

            <div class="stat-item">
                <div class="stat-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="stat-number" data-count="95">0</div>
                <div class="stat-label">Taux de succès</div>
            </div>
        </div>
    </section>

    <section class="expertise-section" id="expertises">
        <div class="expertise-container">
            <header class="expertise-header">
                <div class="expertise-title-group">
                    <p class="expertise-label">
                        <span class="label-icon"><i class="fas fa-cogs"></i></span>
                        Mes Domaines d'Expertise
                    </p>
                    <h2 class="expertise-title">
                        Spécialisations et <span class="text-orange">compétences</span> juridiques
                    </h2>
                </div>
                <a href="{{ url('/expertises') }}" class="btn-orange">
                    <i class="fas fa-clipboard-list"></i> 
                    <span>Tous mes services</span>
                </a>
            </header>

            <div class="expertise-grid">
                <div class="expertise-card" onclick="window.location.href='{{ url('/droitimmobillier') }}'">
                    <div class="card-icon">
                        <i class="fas fa-building"></i>
                    </div>
                    <img src="{{ asset('img/imobil.png') }}" alt="Droit Immobilier" class="card-image" onerror="this.src='https://images.unsplash.com/photo-1560518883-ce09059eeffa?w=600'">
                    <div class="card-overlay">
                        <span class="card-text">Droit Immobilier</span>
                        <p class="card-description">Achat, vente, litiges, copropriété</p>
                    </div>
                </div>
                
                <div class="expertise-card" onclick="window.location.href='{{ url('/droitbancaire') }}'">
                    <div class="card-icon">
                        <i class="fas fa-landmark"></i>
                    </div>
                    <img src="{{ asset('img/bancaire.png') }}" alt="Droit Bancaire" class="card-image" onerror="this.src='https://images.unsplash.com/photo-1541354329998-f4d9a9f9297f?w=600'">
                    <div class="card-overlay">
                        <span class="card-text">Droit Bancaire</span>
                        <p class="card-description">Crédits, surendettement, litiges bancaires</p>
                    </div>
                </div>
                
                <div class="expertise-card" onclick="window.location.href='{{ url('/droitconstruction') }}'">
                    <div class="card-icon">
                        <i class="fas fa-hard-hat"></i>
                    </div>
                    <img src="{{ asset('img/Construction.png') }}" alt="Droit de la Construction" class="card-image" onerror="this.src='https://images.unsplash.com/photo-1503387762-592deb58ef4e?w=600'">
                    <div class="card-overlay">
                        <span class="card-text">Droit de la Construction</span>
                        <p class="card-description">Marchés, responsabilité, garanties</p>
                    </div>
                </div>
                
                <div class="expertise-card" onclick="window.location.href='{{ url('/droitfamille') }}'">
                    <div class="card-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <img src="{{ asset('img/reu1.png') }}" alt="Droit de la Consommation" class="card-image" onerror="this.src='https://images.unsplash.com/photo-1556742502-ec7c0e9f34b1?w=600'">
                    <div class="card-overlay">
                        <span class="card-text">Droit de la Famille</span>
                        <p class="card-description">Divorce, succession, protection</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <section class="whyme-section">
        <div class="whyme-container">
            <div class="whyme-header-content">
                <div class="whyme-title-group">
                    <p class="whyme-label">
                        <span class="label-icon"><i class="fas fa-handshake"></i></span>
                        Pourquoi choisir mon cabinet ?
                    </p>
                    <h2 class="whyme-main-title">
                        Votre succès juridique, <span class="text-orange">ma priorité</span> absolue
                    </h2>
                </div>
                <a href="{{ url('/contact') }}" class="btn-orange">
                    <i class="fas fa-comments"></i> 
                    <span>Échanger ensemble</span>
                </a>
            </div>

            <div class="whyme-main-content">
                <div class="whyme-image-col">
                    <div class="image-wrapper">
                        <img src="{{ asset('img/image.png') }}" alt="Maître Koundé expliquant" class="whyme-image" onerror="this.src='https://images.unsplash.com/photo-1507679799987-c73779587ccf?w=600'">
                        <div class="floating-testimonial">
                            <div class="testimonial-content">
                                <i class="fas fa-quote-left"></i>
                                <p>Maître Koundé a su défendre mes intérêts avec une expertise remarquable.</p>
                                <div class="client-info">
                                    <strong>Pierre D.</strong>
                                    <span>Client satisfait</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="whyme-features-grid">
                    <div class="whyme-feature-card">
                        <div class="feature-icon-wrapper">
                            <span class="feature-icon">
                                <i class="fas fa-medal"></i>
                            </span>
                        </div>
                        <h3 class="feature-title">Expertise avérée et reconnue</h3>
                        <p class="feature-description">
                            Plus de 20 ans d'expérience au service de la défense de vos droits et intérêts.
                        </p>
                    </div>
                    <div class="whyme-feature-card">
                        <div class="feature-icon-wrapper">
                            <span class="feature-icon">
                                <i class="fas fa-chess-knight"></i>
                            </span>
                        </div>
                        <h3 class="feature-title">Stratégie juridique sur mesure</h3>
                        <p class="feature-description">
                            Je conçois des stratégies personnalisées, adaptées à votre situation unique.
                        </p>
                    </div>
                    <div class="whyme-feature-card">
                        <div class="feature-icon-wrapper">
                            <span class="feature-icon">
                                <i class="fas fa-heart"></i>
                            </span>
                        </div>
                        <h3 class="feature-title">Approche humaine et transparente</h3>
                        <p class="feature-description">
                            Pour chaque client, je privilégie l'écoute, la bienveillance et la transparence.
                        </p>
                    </div>
                    <div class="whyme-feature-card">
                        <div class="feature-icon-wrapper">
                            <span class="feature-icon">
                                <i class="fas fa-shield-alt"></i>
                            </span>
                        </div>
                        <h3 class="feature-title">Engagement total et dévoué</h3>
                        <p class="feature-description">
                            Je m'engage à vos côtés jusqu'à la résolution complète de votre dossier.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
   
    <section class="process-section">
        <div class="process-container">
            <header class="process-header">
                <div class="process-title-group">
                    <p class="process-label">
                        <span class="label-icon"><i class="fas fa-road"></i></span>
                        Notre Méthodologie
                    </p>
                    <h2 class="process-main-title">
                        Un accompagnement <span class="text-orange">étape par étape</span> pour votre sérénité
                    </h2>
                </div>
                <a href="{{ url('/contact') }}" class="btn-orange">
                    <i class="fas fa-play-circle"></i> 
                    <span>Démarrer mon projet</span>
                </a>
            </header>

            <div class="process-main-content">
                <div class="process-steps">
                    <div class="process-step-item">
                        <div class="step-number">
                            <i class="fas fa-comments"></i>
                        </div>
                        <div class="step-content">
                            <h3 class="step-title">Consultation Initiale Personnalisée</h3>
                            <p class="step-description">
                                Nous évaluons ensemble votre situation lors d'un premier échange approfondi et confidentiel.
                            </p>
                        </div>
                    </div>
                    <div class="process-step-item">
                        <div class="step-number">
                            <i class="fas fa-chess-board"></i>
                        </div>
                        <div class="step-content">
                            <h3 class="step-title">Élaboration de la Stratégie Juridique</h3>
                            <p class="step-description">
                                Je conçois une défense ou un conseil sur mesure, adapté à vos objectifs spécifiques.
                            </p>
                        </div>
                    </div>
                    <div class="process-step-item">
                        <div class="step-number">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <div class="step-content">
                            <h3 class="step-title">Accompagnement Constant et Réactif</h3>
                            <p class="step-description">
                                Je reste à vos côtés à chaque étape, garantissant un suivi rigoureux jusqu'à la résolution.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="process-image-col">
                    <div class="process-stats-bar">
                        <span class="stat-box">
                            <span class="stat-value">20+</span>
                            <span class="stat-label">Ans <br> d'Expérience</span>
                        </span>
                        <span class="stat-box">
                            <span class="stat-value">500+</span>
                            <span class="stat-label">Clients <br> Satisfaits</span>
                        </span>
                    </div>
                    <img src="{{ asset('img/kj.png') }}" alt="Processus juridique" class="process-image" onerror="this.src='https://images.unsplash.com/photo-1450101499163-c8848c66ca85?w=800'">
                </div>
            </div>
        </div>
    </section>

    <!-- Blog Section avec chargement dynamique CORRIGÉ -->
    <section class="blog-section" id="blog">
        <div class="blog-container">
            <header class="blog-header">
                <div class="blog-title-group">
                    <p class="blog-label">
                        <span class="label-icon"><i class="fas fa-newspaper"></i></span>
                        Actualités Juridiques
                    </p>
                    <h2 class="blog-main-title">
                        Restez informé grâce à notre <span class="highlight-orange">veille juridique</span>
                    </h2>
                </div>
                <a href="{{ url('/blog') }}" class="btn-orange">
                    <i class="fas fa-arrow-right"></i> 
                    <span>Voir tous les articles</span>
                </a>
            </header>

            @if($blogs && $blogs->count() > 0)
                <div class="blog-grid">
                    @foreach($blogs->take(3) as $blog)
                    <div class="blog-post-card" 
                         onclick="handleBlogClick({{ $blog->id }}, {{ $blog->youtube_url ? 'true' : 'false' }})"
                         data-blog-id="{{ $blog->id }}"
                         data-has-video="{{ $blog->youtube_url ? 'true' : 'false' }}">
                        
                        <!-- Catégorie -->
                        <div class="post-category {{ $blog->youtube_url ? 'video-category' : '' }}">
                            <i class="fas {{ $blog->youtube_url ? 'fa-play' : 'fa-newspaper' }}"></i> 
                            {{ $blog->youtube_url ? 'Vidéo' : 'Article' }}
                        </div>
                        
                        <!-- Contenu média : Vidéo YouTube avec lecteur intégré ou Image -->
                        @if($blog->youtube_url)
                            <!-- Lecteur YouTube intégré -->
                            <div class="video-container" id="video-container-{{ $blog->id }}">
                                <!-- Miniature de la vidéo -->
                                <img 
                                    src="https://img.youtube.com/vi/{{ $blog->getYouTubeId() }}/hqdefault.jpg" 
                                    alt="{{ $blog->title }}"
                                    class="video-thumbnail"
                                >
                                
                                <!-- Overlay de lecture -->
                                <div class="video-play-overlay" onclick="event.stopPropagation(); playVideo({{ $blog->id }}, '{{ $blog->getYouTubeId() }}')">
                                    <div class="play-button">
                                        <i class="fas fa-play"></i>
                                    </div>
                                </div>
                                
                                <!-- Iframe YouTube (caché au départ) -->
                                <iframe 
                                    id="youtube-iframe-{{ $blog->id }}"
                                    class="youtube-embed"
                                    src=""
                                    title="{{ $blog->title }}"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                    allowfullscreen
                                    style="display: none;"
                                ></iframe>
                            </div>
                        @else
                            <!-- Image de l'article - CORRECTION ICI -->
                            @if($blog->image)
                                <img src="{{ Storage::url($blog->image) }}" alt="{{ $blog->title }}" class="post-image" onerror="this.src='https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=600'">
                            @else
                                <div class="post-image default-blog-image">
                                    <i class="fas fa-newspaper"></i>
                                </div>
                            @endif
                        @endif
                        
                        <!-- Overlay avec contenu -->
                        <div class="post-content-overlay">
                            <h3 class="post-title">
                                {{ Str::limit($blog->title, 60) }}
                            </h3>
                            <div class="post-meta">
                                <span class="meta-item">
                                    <i class="fa-solid fa-user me-1"></i> {{ $blog->author ?? 'Maître Koundé' }}
                                </span>
                                <span class="meta-item">
                                    <i class="fa-solid fa-calendar-days me-1"></i> {{ $blog->created_at->format('d M Y') }}
                                </span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="blog-grid">
                    <!-- Article statique 1 -->
                    <div class="blog-post-card article-card" onclick="showBlogModal(1)">
                        <div class="post-category">
                            <i class="fas fa-newspaper"></i> Article
                        </div>
                        <img src="https://images.unsplash.com/photo-1589829545856-d10d557cf95f?w=600" alt="Article juridique" class="post-image">
                        <div class="post-content-overlay">
                            <h3 class="post-title">Les nouvelles réformes du droit immobilier en 2025</h3>
                            <p class="post-excerpt">
                                Découvrez les changements majeurs qui impactent vos transactions immobilières cette année.
                            </p>
                            <div class="post-meta">
                                <span class="meta-item">
                                    <i class="fas fa-user-tie"></i> Maître Koundé
                                </span>
                                <span class="meta-item">
                                    <i class="fas fa-calendar-alt"></i> 15 Oct 2025
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Vidéo statique -->
                    <div class="blog-post-card video-card" onclick="playVideo(2, 'dQw4w9WgXcQ')">
                        <div class="post-category video-category">
                            <i class="fas fa-play"></i> Vidéo
                        </div>
                        <div class="video-thumbnail-container">
                            <img src="https://images.unsplash.com/photo-1505664194779-8beaceb93744?w=600" alt="Vidéo" class="post-image">
                            <div class="video-play-icon">
                                <i class="fas fa-play"></i>
                            </div>
                        </div>
                        <div class="post-content-overlay">
                            <h3 class="post-title">Comment se protéger dans un litige bancaire ?</h3>
                            <p class="post-excerpt">
                                Nos conseils d'expert en vidéo pour défendre vos droits face aux banques.
                            </p>
                            <div class="post-meta">
                                <span class="meta-item">
                                    <i class="fas fa-user-tie"></i> Maître Koundé
                                </span>
                                <span class="meta-item">
                                    <i class="fas fa-calendar-alt"></i> 10 Oct 2025
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Article statique 2 -->
                    <div class="blog-post-card article-card" onclick="showBlogModal(3)">
                        <div class="post-category">
                            <i class="fas fa-newspaper"></i> Article
                        </div>
                        <img src="https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=600" alt="Article" class="post-image">
                        <div class="post-content-overlay">
                            <h3 class="post-title">Garantie décennale : vos droits en construction</h3>
                            <p class="post-excerpt">
                                Tout ce que vous devez savoir sur la garantie décennale et vos recours.
                            </p>
                            <div class="post-meta">
                                <span class="meta-item">
                                    <i class="fas fa-user-tie"></i> Maître Koundé
                                </span>
                                <span class="meta-item">
                                    <i class="fas fa-calendar-alt"></i> 05 Oct 2025
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>

    <!-- Modal pour afficher les détails du blog -->
    <div class="modal fade blog-modal" id="blogModal" tabindex="-1" aria-labelledby="blogModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="blogModalTitle">Titre de l'article</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="blogModalBody">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Données des blogs
        const blogsData = {
            @if($blogs && $blogs->count() > 0)
                @foreach($blogs->take(3) as $blog)
                {{ $blog->id }}: {
                    title: `{{ addslashes($blog->title) }}`,
                    description: `{{ addslashes($blog->description) }}`,
                    content: `{!! addslashes($blog->content) !!}`,
                    author: `{{ addslashes($blog->author ?? 'Maître Koundé') }}`,
                    createdAt: `{{ $blog->created_at->format('d M Y') }}`,
                    image: `{{ $blog->image ? Storage::url($blog->image) : '' }}`,
                    youtubeUrl: `{{ $blog->youtube_url }}`
                },
                @endforeach
            @else
                // Données statiques par défaut
                1: {
                    title: 'Les nouvelles réformes du droit immobilier en 2025',
                    description: 'Un aperçu complet des changements législatifs majeurs',
                    content: `
                        <p>L'année 2025 marque un tournant important dans le droit immobilier français avec plusieurs réformes majeures qui impactent directement les propriétaires, locataires et investisseurs.</p>
                        
                        <h4>Les points clés à retenir :</h4>
                        <ul>
                            <li>Nouvelles obligations en matière de performance énergétique</li>
                            <li>Renforcement de la protection des locataires</li>
                            <li>Simplification des procédures de vente</li>
                            <li>Modifications des règles de copropriété</li>
                        </ul>
                        
                        <p>Notre cabinet vous accompagne pour naviguer ces changements et protéger vos intérêts dans toutes vos transactions immobilières.</p>
                    `,
                    author: 'Maître Koundé',
                    createdAt: '15 Oct 2025'
                },
                3: {
                    title: 'Garantie décennale : vos droits en construction',
                    description: 'Guide complet sur la garantie décennale et les recours possibles',
                    content: `
                        <p>La garantie décennale est une protection essentielle pour tout propriétaire d'un bien immobilier neuf ou rénové. Elle couvre les dommages qui compromettent la solidité de l'ouvrage ou le rendent impropre à sa destination.</p>
                        
                        <h4>Que couvre la garantie décennale ?</h4>
                        <ul>
                            <li>Les défauts structurels majeurs</li>
                            <li>Les problèmes d'étanchéité graves</li>
                            <li>Les vices affectant la solidité du bâtiment</li>
                            <li>Les désordres rendant le bien inhabitable</li>
                        </ul>
                        
                        <h4>Comment faire valoir vos droits ?</h4>
                        <p>En cas de découverte d'un désordre, il est crucial d'agir rapidement. Notre cabinet vous guide dans les démarches pour faire valoir vos droits et obtenir réparation.</p>
                    `,
                    author: 'Maître Koundé',
                    createdAt: '05 Oct 2025'
                }
            @endif
        };

        function handleBlogClick(blogId, hasVideo) {
            if (hasVideo) {
                // Pour les vidéos, on ne fait rien car le clic est géré par playVideo
                return;
            } else {
                // Pour les articles, on affiche le modal
                showBlogModal(blogId);
            }
        }

        function showBlogModal(blogId) {
            const blog = blogsData[blogId];
            if (!blog) return;

            // Mettre à jour le titre du modal
            document.getElementById('blogModalTitle').textContent = blog.title;

            // Construire le contenu du modal
            const modalBody = document.getElementById('blogModalBody');
            modalBody.innerHTML = `
                <div class="blog-meta">
                    <div class="blog-meta-item">
                        <i class="fas fa-user"></i>
                        <span>${blog.author}</span>
                    </div>
                    <div class="blog-meta-item">
                        <i class="fas fa-calendar-days"></i>
                        <span>${blog.createdAt}</span>
                    </div>
                    <div class="blog-meta-item">
                        <i class="fas fa-newspaper"></i>
                        <span>Article</span>
                    </div>
                </div>

                ${blog.image ? `
                <div class="text-center mb-4">
                    <img src="${blog.image}" alt="${blog.title}" class="img-fluid rounded" style="max-height: 300px; object-fit: cover;">
                </div>
                ` : ''}

                <div class="blog-description">
                    <strong>Description :</strong> ${blog.description}
                </div>

                <div class="blog-content">
                    ${blog.content}
                </div>
            `;

            // Afficher le modal
            const modal = new bootstrap.Modal(document.getElementById('blogModal'));
            modal.show();
        }

        function playVideo(blogId, videoId) {
            const container = document.getElementById(`video-container-${blogId}`);
            const iframe = document.getElementById(`youtube-iframe-${blogId}`);
            
            // Afficher l'iframe et masquer la miniature
            iframe.style.display = 'block';
            iframe.src = `https://www.youtube.com/embed/${videoId}?autoplay=1&rel=0&modestbranding=1`;
            
            // Marquer comme en cours de lecture
            container.classList.add('video-playing');
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Animation des statistiques
            const statNumbers = document.querySelectorAll('.stat-number');
            
            const animateStats = () => {
                statNumbers.forEach(stat => {
                    const target = parseInt(stat.getAttribute('data-count'));
                    const duration = 2000;
                    const step = target / (duration / 16);
                    let current = 0;
                    
                    const timer = setInterval(() => {
                        current += step;
                        if (current >= target) {
                            stat.textContent = target + (stat.getAttribute('data-count') === '95' ? ' %' : '+');
                            clearInterval(timer);
                        } else {
                            stat.textContent = Math.floor(current) + (stat.getAttribute('data-count') === '95' ? ' %' : '+');
                        }
                    }, 16);
                });
            };
            
            const statsObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        animateStats();
                        statsObserver.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.5 });
            
            if (document.querySelector('.stats-section')) {
                statsObserver.observe(document.querySelector('.stats-section'));
            }
            
            // Animation des cartes au défilement
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };
            
            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                        entry.target.style.animationPlayState = 'running';
                    }
                });
            }, observerOptions);
            
            // Observer les cartes de blog et d'expertise
            const blogCards = document.querySelectorAll('.blog-post-card');
            const expertiseCards = document.querySelectorAll('.expertise-card');
            const featureCards = document.querySelectorAll('.whyme-feature-card');
            
            [...blogCards, ...expertiseCards, ...featureCards].forEach(card => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                observer.observe(card);
            });
            
            // Gestion des boutons
            document.querySelectorAll('.btn-orange, .btn-white').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    if (this.id === 'rdv-btn') {
                        e.preventDefault();
                        this.style.transform = 'scale(0.95)';
                        setTimeout(() => {
                            this.style.transform = 'scale(1)';
                        }, 150);
                        alert('Merci pour votre intérêt ! Un membre du cabinet vous contactera dans les plus brefs délais pour convenir d\'un rendez-vous.');
                    } else if (this.id === 'call-btn') {
                        e.preventDefault();
                        window.location.href = 'tel:+33666690080';
                    } else if (this.id === 'about-btn') {
                        e.preventDefault();
                        window.location.href = '{{ url("/about") }}';
                    }
                });
            });
            
            // Navigation fluide
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    const targetId = this.getAttribute('href');
                    if (targetId === '#') return;
                    
                    const targetElement = document.querySelector(targetId);
                    if (targetElement) {
                        window.scrollTo({
                            top: targetElement.offsetTop - 80,
                            behavior: 'smooth'
                        });
                    }
                });
            });

            // Chargement lazy des miniatures YouTube
            const videoThumbnails = document.querySelectorAll('.video-thumbnail');
            videoThumbnails.forEach(thumbnail => {
                thumbnail.setAttribute('loading', 'lazy');
            });

            // Fermer les vidéos YouTube quand le modal se ferme
            document.getElementById('blogModal').addEventListener('hidden.bs.modal', function() {
                // Réinitialiser les iframes YouTube si nécessaire
                const iframes = document.querySelectorAll('.youtube-embed');
                iframes.forEach(iframe => {
                    iframe.src = '';
                });
            });
        });
    </script>
</body>
</html>
    
@endsection