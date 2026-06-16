<?php
?>
<!DOCTYPE html>
<html lang="tl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Brgy 727 Community Health Awareness System</title>
    <link rel="stylesheet" href="homepage.css">
</head>

<body>
    <header class="header">
        <div class="header-left">
            <div class="logo-section">
                <div class="logo-icon">⚕</div>
                <div class="logo-text">
                    <h1>BRGY 727</h1>
                    <p>Monitoring System</p>
                </div>
            </div>
        </div>

        <div class="header-right">
            <a href="login_user.php" class="login-btn"><b>USER LOGIN</b></a>
            <a href="login.php" class="login-btn"><b>ADMIN</b></a>
        </div>
    </header>
    
    <section class="hero">
        <div class="hero-content">
            <h1>COMMUNITY AWARENESS<br>MONITORING SYSTEM</h1>
            <p class="hero-subtitle">
                Sagutan ang Survey para sa Iyong Kaligtasan. Ang iyong sagot ay
                makakatulong sa barangay sa oras ng emergency.
            </p>
            <div class="hero-buttons">
                <a href="login_user.php" class="survey-btn">Take Survey</a>
            </div>
        </div>
    </section>

    <section class="health-alert-section">
        <div class="health-alert-container">

            <!-- Header with Alert Icon -->
            <div class="health-alert-header">
                <div class="alert-icon-circle">⚠️</div>
                <div>
                    <h2 class="health-alert-title">Community Health Alert</h2>
                    <p class="health-alert-desc">
                        Protect yourself and your family from common diseases in the Philippines. 
                        Early awareness and simple daily habits save lives. Know the risks, take action, 
                        and encourage your neighbors.
                    </p>
                </div>
            </div>

            <!-- Disease Cards Grid -->
            <div class="disease-cards">
                <div class="disease-card">
                    <h3>Dengue</h3>
                    <p>Eliminate stagnant water weekly. Use the 4S strategy.</p>
                </div>

                <div class="disease-card">
                    <h3>Leptospirosis</h3>
                    <p>Avoid wading in floodwater. Wear rubber boots after typhoons.</p>
                </div>

                <div class="disease-card">
                    <h3>Influenza</h3>
                    <p>Get your annual flu vaccine. Wash hands frequently.</p>
                </div>

                <div class="disease-card">
                    <h3>Typhoid</h3>
                    <p>Drink only safe, boiled or bottled water. Practice proper handwashing.</p>
                </div>

                <div class="disease-card">
                    <h3>COVID-19</h3>
                    <p>Stay updated on booster doses. Mask up in crowded indoor spaces.</p>
                </div>

                <div class="disease-card">
                    <h3>Tuberculosis</h3>
                    <p>Cough lasting 2+ weeks? Get a free sputum test at your RHU.</p>
                </div>
            </div>

            <!-- Footer Note -->
            <div class="health-footer">
                <p>Information based on DOH Philippines and WHO guidelines. Consult your barangay health worker for personalized advice.</p>
            </div>
        </div>
    </section>

    <!-- DISEASE PREVENTION GUIDE  -->
<?php

$diseases = [

'dengue' => [
'name' => 'Dengue',
'tip' => 'Aedes mosquitoes breed in CLEAN, still water. Focus on eliminating standing water around your home.',
'cards' => [
['title'=>'Empty Flower Vases','text'=>'Change water daily or remove vases entirely to eliminate mosquito breeding sites.','priority'=>true],
['title'=>'Cover Water Containers','text'=>'Keep pails, drums, and tanks tightly covered at all times.','priority'=>true],
['title'=>'Remove Stagnant Water','text'=>'Check for water accumulation in unused items like tires and cans.','priority'=>true],
['title'=>'Clean Gutters & Drains','text'=>'Prevent water from pooling in roof gutters and drainage channels.'],
['title'=>'Use Mosquito Repellent','text'=>'Apply mosquito repellent, especially during dawn and dusk.'],
['title'=>'Weekly Home Inspection','text'=>'Inspect your home every week for potential mosquito breeding sites.']
]
],

'leptospirosis' => [
'name' => 'Leptospirosis',
'tip' => 'Leptospirosis spreads through water contaminated with animal urine.',
'cards' => [
['title'=>'Avoid Flood Water','text'=>'Avoid walking through floodwaters whenever possible.','priority'=>true],
['title'=>'Wear Boots','text'=>'Wear waterproof boots during cleanup activities.','priority'=>true],
['title'=>'Cover Open Wounds','text'=>'Protect cuts from contaminated water.','priority'=>true],
['title'=>'Control Rodents','text'=>'Maintain cleanliness to reduce rat infestation.'],
['title'=>'Disinfect Areas','text'=>'Clean flood-affected areas thoroughly.'],
['title'=>'Seek Early Treatment','text'=>'Consult a healthcare provider if symptoms appear.']
]
],

'influenza' => [
'name' => 'Influenza',
'tip' => 'Influenza spreads through respiratory droplets.',
'cards' => [
['title'=>'Wash Hands Frequently','text'=>'Use soap and water regularly.','priority'=>true],
['title'=>'Cover Coughs & Sneezes','text'=>'Use tissues or your elbow.','priority'=>true],
['title'=>'Stay Home When Sick','text'=>'Prevent spreading the virus.','priority'=>true],
['title'=>'Wear a Mask','text'=>'Especially in crowded places.'],
['title'=>'Disinfect Surfaces','text'=>'Clean frequently touched objects.'],
['title'=>'Get Vaccinated','text'=>'Annual vaccination is recommended.']
]
],

'typhoid' => [
'name' => 'Typhoid',
'tip' => 'Typhoid fever is commonly caused by contaminated food and water.',
'cards' => [
['title'=>'Drink Safe Water','text'=>'Boil or purify drinking water.','priority'=>true],
['title'=>'Wash Hands','text'=>'Before eating and after using the toilet.','priority'=>true],
['title'=>'Cook Food Thoroughly','text'=>'Avoid undercooked meals.','priority'=>true],
['title'=>'Wash Produce','text'=>'Clean fruits and vegetables.'],
['title'=>'Maintain Food Hygiene','text'=>'Store food properly.'],
['title'=>'Avoid Unsafe Vendors','text'=>'Choose trusted food sources.']
]
],

'covid' => [
'name' => 'COVID-19',
'tip' => 'COVID-19 spreads mainly through respiratory droplets.',
'cards' => [
['title'=>'Wash Hands','text'=>'Wash hands regularly.','priority'=>true],
['title'=>'Stay Home When Sick','text'=>'Avoid exposing others.','priority'=>true],
['title'=>'Improve Ventilation','text'=>'Keep rooms well ventilated.','priority'=>true],
['title'=>'Wear a Mask','text'=>'Especially in crowded places.'],
['title'=>'Maintain Distance','text'=>'Avoid unnecessary close contact.'],
['title'=>'Seek Medical Advice','text'=>'If symptoms worsen.']
]
],

'tb' => [
'name' => 'Tuberculosis',
'tip' => 'Tuberculosis spreads through the air when an infected person coughs.',
'cards' => [
['title'=>'Complete Treatment','text'=>'Take medicines exactly as prescribed.','priority'=>true],
['title'=>'Cover Coughs','text'=>'Use tissue or elbow.','priority'=>true],
['title'=>'Improve Ventilation','text'=>'Allow fresh air indoors.','priority'=>true],
['title'=>'Get Tested Early','text'=>'Seek testing if symptoms persist.'],
['title'=>'Avoid Smoking','text'=>'Smoking damages the lungs further.'],
['title'=>'Regular Checkups','text'=>'Attend follow-up appointments.']
]
]

];

?>

<section class="prevention-section">

    <div class="prevention-container">

        <div class="prevention-header">
            <h2>Disease Prevention Guide</h2>
            <p>
                Select a disease below to view targeted prevention tips
                you can apply at home and in your community.
            </p>
        </div>

        <div class="disease-tabs">

            <?php
            $first = true;
            foreach($diseases as $key => $disease):
            ?>

                <button
                    class="disease-tab <?= $first ? 'active' : '' ?>"
                    data-disease="<?= $key ?>"
                >
                    <?= $disease['name'] ?>
                </button>

            <?php
            $first = false;
            endforeach;
            ?>

            <button class="disease-tab" onclick="openDiseaseModal()">
                More Diseases
            </button>

        </div>

        <div id="preventionCards" class="prevention-cards"></div>

        <div class="prevention-tip" id="preventionTip"></div>

    </div>

</section>

<div id="diseaseModal" class="disease-modal">

    <div class="disease-modal-content">

        <h3>Need More Information?</h3>

        <p>
            For diseases not listed in this guide,
            please contact your Barangay Health Center.
        </p>

        <div class="contact-number">
            📞 09xx-xxx-xxxx
        </div>

        <button onclick="closeDiseaseModal()">
            Close
        </button>

    </div>

</div>

<script>

const diseaseData = <?= json_encode($diseases); ?>;

function loadDisease(diseaseKey){

    const disease = diseaseData[diseaseKey];

    let cardsHtml = '';

    disease.cards.forEach(card => {

        cardsHtml += `
            <div class="prevention-card">

                <div class="prevention-card-header">

                    <h4>${card.title}</h4>

                    ${
                        card.priority
                        ? '<span class="priority-badge">Priority</span>'
                        : ''
                    }

                </div>

                <p>${card.text}</p>

            </div>
        `;

    });

    document.getElementById('preventionCards').innerHTML = cardsHtml;

    document.getElementById('preventionTip').innerHTML = `
        <div class="prevention-tip-icon">✓</div>
        <p>
            <strong>Did you know?</strong>
            ${disease.tip}
        </p>
    `;
}

document.querySelectorAll('.disease-tab[data-disease]')
.forEach(tab => {

    tab.addEventListener('click', function(){

        document
        .querySelectorAll('.disease-tab')
        .forEach(btn => btn.classList.remove('active'));

        this.classList.add('active');

        loadDisease(this.dataset.disease);

    });

});

loadDisease('dengue');

function openDiseaseModal(){
    document.getElementById('diseaseModal').style.display = 'flex';
}

function closeDiseaseModal(){
    document.getElementById('diseaseModal').style.display = 'none';
}

window.addEventListener('click', function(e){

    const modal = document.getElementById('diseaseModal');

    if(e.target === modal){
        modal.style.display = 'none';
    }

});

</script>
     <!-- TRUSTED WEBSITES -->
    <section class="trusted-sites-section">

    <div class="trusted-sites-container">

        <h2>Trusted Health Websites</h2>

        <div class="trusted-sites-grid">

            <a href="https://doh.gov.ph"
               target="_blank"
               class="trusted-site-card">

                <h3>Department of Health (DOH) Philippines</h3>

                <p>
                    Official government health advisories,
                    outbreak bulletins, and disease-specific guidelines.
                </p>

            </a>

            <a href="https://www.who.int"
               target="_blank"
               class="trusted-site-card">

                <h3>World Health Organization (WHO)</h3>

                <p>
                    Global health standards and research on dengue,
                    TB, influenza, COVID-19, and more.
                </p>

            </a>

            <a href="https://redcross.org.ph"
               target="_blank"
               class="trusted-site-card">

                <h3>Philippine Red Cross</h3>

                <p>
                    Blood donation, emergency health services,
                    and disaster response information.
                </p>

            </a>

            <a href="https://wwwnc.cdc.gov/travel"
               target="_blank"
               class="trusted-site-card">

                <h3>CDC — Travelers' Health</h3>

                <p>
                    Vaccination recommendations and disease prevention
                    information for travelers.
                </p>

            </a>

            <a href="https://ntp.doh.gov.ph"
               target="_blank"
               class="trusted-site-card">

                <h3>DOH — National TB Program</h3>

                <p>
                    TB prevention, diagnosis, treatment, and DOTS
                    program information.
                </p>

            </a>

            <a href="https://www.philhealth.gov.ph"
               target="_blank"
               class="trusted-site-card">

                <h3>PhilHealth</h3>

                <p>
                    Konsulta Package, outpatient consultations,
                    and member health benefits.
                </p>

            </a>

        </div>

        <div class="trusted-sites-footer">

            All materials are free to access.
            For additional assistance, contact your Barangay Health Center.

        </div>

    </div>

</section>
    <!-- ============================================
         CONTENT SECTION
         ============================================ -->
    <section class="content">
        <div class="content-container">
            <h2 class="content-title">Kahalagahan ng Kalusugan at Kahandaan</h2>
            <p class="content-paragraph">
                Ang pagiging handa ay mahalaga upang makaiwas sa panganib sa oras ng sakuna.
            </p>
            <p class="content-paragraph">
                Sa tamang impormasyon, mas mabilis ang pagresponde ng barangay.
            </p>
            <div class="content-highlight">
                <b>Ang paghahanda ngayon ay pagliligtas bukas.</b>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="hotline-footer">
        <div class="footer-container">
            <h2 class="footer-title">BRGY 727 MONITORING SYSTEM</h2>
            <p class="footer-description">
                Para sa kaligtasan at kahandaan ng bawat residente ng Barangay 727.
            </p>
            <div class="contact-item">Emergency Hotline: 911</div>
            <div class="contact-item">Brgy Hotline: 0917-XXX-XXXX</div>
        </div>
    </footer>

    <div class="bottom-accent"></div>
</body>
</html>
