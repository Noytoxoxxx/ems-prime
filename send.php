<?php
// =======================================================================
// CONFIGURATION DU SYSTEME EMS - PRIME RP (MIS À POUR 2026)
// =======================================================================

// Ton lien webhook officiel
define('WEBHOOK_EMS', 'https://discord.com/api/webhooks/1505667584131993713/E6xgjRGSCmQfdSWMBYnwfDKzkllf9jLsjizjHdPshBvmPMvdifL7gYodfozESv53WYE9');

define('BOT_NAME', 'Secrétariat Hospitalier • Prime RP');
define('BOT_AVATAR', 'https://i.imgur.com/v8bS8P7.png');

// =======================================================================
// TRAITEMENT DES FORMULAIRES
// =======================================================================

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form_type = $_POST['form_type'] ?? '';

    // --- 1. FORMULAIRE : RECRUTEMENT ---
    if ($form_type === 'recrutement') {
        $discord = htmlspecialchars($_POST['discord_tag']);
        
        $q1  = htmlspecialchars($_POST['q1_nom_prenom']);
        $q2  = htmlspecialchars($_POST['q2_age']);
        $q3  = htmlspecialchars($_POST['q3_permis']);
        $q4  = htmlspecialchars($_POST['q4_anciennete']);
        $q5  = htmlspecialchars($_POST['q5_metier_actuel']);
        $q6  = htmlspecialchars($_POST['q6_parcours']);
        $q7  = htmlspecialchars($_POST['q7_competences']);
        $q8  = htmlspecialchars($_POST['q8_motivations']);
        $q9  = htmlspecialchars($_POST['q9_pourquoi_vous']);
        $q10 = htmlspecialchars($_POST['q10_qualites']);
        $q11 = htmlspecialchars($_POST['q11_defauts']);
        $q12 = htmlspecialchars($_POST['q12_semaine']);
        $q13 = htmlspecialchars($_POST['q13_weekend']);

        $data = [
            "username" => BOT_NAME,
            "avatar_url" => BOT_AVATAR,
            "embeds" => [[
                "title" => "🩺 NOUVEAU DOSSIER DE CANDIDATURE EMS",
                "description" => "Un citoyen vient de soumettre son curriculum vitae pour rejoindre les rangs du Centre Médical.\n\n**Candidateur Discord :** <@{$discord}> ( `{$discord}` )\n\n---",
                "color" => 15158332, 
                "fields" => [
                    ["name" => "👤 Nom & Prénom RP", "value" => "```\n{$q1}\n```", "inline" => true],
                    ["name" => "🎂 Âge (RP / OOC)", "value" => "```\n{$q2}\n```", "inline" => true],
                    ["name" => "🚗 Permis de Conduire", "value" => "```\n{$q3}\n```", "inline" => true],
                    ["name" => "🏙️ Présence en Ville", "value" => "```\n{$q4}\n```", "inline" => true],
                    ["name" => "💼 Métier Actuel", "value" => "• {$q5}", "inline" => false],
                    ["name" => "📜 Historique Professionnel", "value" => "```md\n# Emplois précédents :\n{$q6}\n```", "inline" => false],
                    ["name" => "🩺 Compétences Médicales", "value" => "```md\n* {$q7}\n```", "inline" => false],
                    ["name" => "❤️ Motivations Principales", "value" => ">>> {$q8}", "inline" => false],
                    ["name" => "❓ Pourquoi lui/elle et pas un autre ?", "value" => ">>> {$q9}", "inline" => false],
                    ["name" => "⭐ 3 Qualités", "value" => "```diff\n+ {$q10}\n```", "inline" => true],
                    ["name" => "⚠️ 3 Défauts", "value" => "```diff\n- {$q11}\n
```", "inline" => true],
                    ["name" => "📅 Créneaux - Semaine", "value" => "🕒 {$q12}", "inline" => false],
                    ["name" => "🏖️ Créneaux - Week-end", "value" => "🕒 {$q13}", "inline" => false]
                ],
                "footer" => [
                    "text" => "Direction des Ressources Humaines • Prime RP",
                    "icon_url" => "https://i.imgur.com/v8bS8P7.png"
                ],
                "timestamp" => date("c")
            ]]
        ];
        sendWebhook(WEBHOOK_EMS, $data);

    // --- 2. FORMULAIRE : PRISE DE RENDEZ-VOUS ---
    } elseif ($form_type === 'rdv') {
        $nom = htmlspecialchars($_POST['nom']);
        $prenom = htmlspecialchars($_POST['prenom']);
        $dispo = htmlspecialchars($_POST['dispo']);
        $contact = htmlspecialchars($_POST['contact']);
        $motif = htmlspecialchars($_POST['motif']);
        $commentaire = htmlspecialchars($_POST['commentaire'] ?? 'Aucun commentaire additionnel.');

        $data = [
            "username" => BOT_NAME,
            "avatar_url" => BOT_AVATAR,
            "embeds" => [[
                "title" => "🚑 DEMANDE DE RENDEZ-VOUS MÉDICAL",
                "description" => "Un patient demande une prise en charge ou un examen clinique.\n---",
                "color" => 3447003, 
                "fields" => [
                    ["name" => "👤 Identité du Patient", "value" => "```\n{$prenom} {$nom}\n```", "inline" => true],
                    ["name" => "📞 Moyen de Contact", "value" => "```\n{$contact}\n
```", "inline" => true],
                    ["name" => "📌 Motif de la consultation", "value" => "**{$motif}**", "inline" => false],
                    ["name" => "📅 Disponibilités indiquées", "value" => "💬 {$dispo}", "inline" => false],
                    ["name" => "💬 Notes du Patient", "value" => "*\"{$commentaire}\"*", "inline" => false]
                ],
                "footer" => ["text" => "Secrétariat des Admissions • Prime RP"],
                "timestamp" => date("c")
            ]]
        ];
        sendWebhook(WEBHOOK_EMS, $data);

    // --- 3. FORMULAIRE : REGIE PUB ---
    } elseif ($form_type === 'pub') {
        $nom_rp = htmlspecialchars($_POST['nom_rp']);
        $entreprise = htmlspecialchars($_POST['entreprise']);
        $contact = htmlspecialchars($_POST['contact']);
        $duree = htmlspecialchars($_POST['duree']);
        $description = htmlspecialchars($_POST['description']);

        $data = [
            "username" => BOT_NAME,
            "avatar_url" => BOT_AVATAR,
            "embeds" => [[
                "title" => "📢 DOSSIER PUBLICITAIRE DÉPOSÉ",
                "description" => "Une entreprise souhaite utiliser les espaces publicitaires du site EMS.\n---",
                "color" => 15844367, 
                "fields" => [
                    ["name" => "🏢 Entreprise / Marque", "value" => "```\n{$entreprise}\n```", "inline" => true],
                    ["name" => "👤 Responsable Légal", "value" => "```\n{$nom_rp}\n```", "inline" => true],
                    ["name" => "⏳ Durée du Contrat", "value" => "📆 {$duree}", "inline" => true],
                    ["name" => "📞 Contact Pro", "value" => "📱 {$contact}", "inline" => true],
                    ["name" => "📝 Contenu textuel de l'affiche", "value" => "```\n{$description}\n```", "inline" => false]
                ],
                "footer" => ["text" => "Régie Publicitaire Hospitalière • Prime RP"],
                "timestamp" => date("c")
            ]]
        ];
        sendWebhook(WEBHOOK_EMS, $data);
    }
    
    // Page de redirection/confirmation élégante avec animations d'entrée et de sortie
    echo '
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Traitement Réussi</title>
        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <style>
            .fade-out-custom {
                opacity: 0;
                transform: scale(0.95);
                transition: all 0.4s ease-in-out;
            }
        </style>
    </head>
    <body class="bg-slate-950 flex h-screen items-center justify-center font-sans overflow-hidden">

        <div id="terminal-card" class="text-center p-8 bg-slate-900 border border-slate-800 rounded-2xl max-w-sm shadow-2xl transform scale-95 opacity-0 transition-all duration-500 ease-out">
            
            <div class="relative w-20 h-20 mx-auto mb-4 flex items-center justify-center">
                <div class="absolute inset-0 bg-emerald-500/20 rounded-full animate-ping"></div>
                <div class="relative bg-emerald-500 text-slate-900 text-3xl w-14 h-14 rounded-full flex items-center justify-center font-bold shadow-lg shadow-emerald-500/50">
                    <i class="fa-solid fa-check"></i>
                </div>
            </div>

            <h2 class="text-xl font-black mb-2 text-white tracking-wide uppercase">Transmission réussie</h2>
            <p class="text-slate-400 text-sm mb-6 leading-relaxed">Vos données ont été cryptées et envoyées avec succès sur le réseau des urgences.</p>
            
            <button onclick="leaveTerminal()" class="w-full bg-red-600 hover:bg-red-700 text-white text-sm py-3 rounded-xl font-bold tracking-wider uppercase shadow-lg shadow-red-600/30 hover:shadow-red-600/50 hover:-translate-y-0.5 transition-all cursor-pointer flex items-center justify-center gap-2 group">
                <i class="fa-solid fa-terminal text-xs text-red-300 group-hover:animate-pulse"></i>
                Quitter le terminal
            </button>
        </div>

        <script>
            window.addEventListener(\'DOMContentLoaded\', () => {
                const card = document.getElementById(\'terminal-card\');
                setTimeout(() => {
                    card.classList.remove(\'scale-95\', \'opacity-0\');
                    card.classList.add(\'scale-100\', \'opacity-100\');
                }, 100);
            });

            function leaveTerminal() {
                const card = document.getElementById(\'terminal-card\');
                card.classList.add(\'fade-out-custom\');
                
                setTimeout(() => {
                    window.location.href = "index.html?from=terminal";
                }, 400);
            }
        </script>
    </body>
    </html>';
}

function sendWebhook($url, $data) {
    $options = [
        CURLOPT_URL => $url,
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POSTFIELDS => json_encode($data)
    ];
    $ch = curl_init();
    curl_setopt_array($ch, $options);
    curl_exec($ch);
    curl_close($ch);
}
?>