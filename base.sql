-- ============================================
-- BASE DE DONNEES - Mobile Money V1
-- Devise : Ariary (Ar)
-- SGBD : SQLite
-- ============================================

-- Table des administrateurs
CREATE TABLE IF NOT EXISTS admins (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    login TEXT NOT NULL UNIQUE,
    password TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Table des prefixes de l'operateur
CREATE TABLE IF NOT EXISTS prefixes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    prefixe TEXT NOT NULL UNIQUE,
    actif INTEGER DEFAULT 1
);

-- Table des types d'operations
CREATE TABLE IF NOT EXISTS types_operations (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom TEXT NOT NULL,
    description TEXT,
    actif INTEGER DEFAULT 1
);

-- Table des baremes de frais par tranche de montant
CREATE TABLE IF NOT EXISTS baremes_frais (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    type_operation_id INTEGER NOT NULL,
    montant_min REAL NOT NULL,
    montant_max REAL NOT NULL,
    frais_fixe REAL NOT NULL DEFAULT 0,
    FOREIGN KEY (type_operation_id) REFERENCES types_operations(id) ON DELETE CASCADE
);

-- Table des comptes clients
CREATE TABLE IF NOT EXISTS comptes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    telephone TEXT NOT NULL UNIQUE,
    solde REAL DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Table des transactions (historique)
CREATE TABLE IF NOT EXISTS transactions (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    compte_id INTEGER NOT NULL,
    type_operation_id INTEGER NOT NULL,
    montant REAL NOT NULL,
    frais REAL DEFAULT 0,
    solde_avant REAL DEFAULT 0,
    solde_apres REAL DEFAULT 0,
    destinataire_telephone TEXT,
    date_transaction DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (compte_id) REFERENCES comptes(id),
    FOREIGN KEY (type_operation_id) REFERENCES types_operations(id)
);

-- ============================================
-- VUES SQL
-- ============================================

-- Vue : Situation des comptes clients
CREATE VIEW IF NOT EXISTS vue_situation_comptes AS
SELECT
    c.id,
    c.telephone,
    c.solde,
    c.created_at,
    COUNT(t.id) AS nombre_transactions
FROM comptes c
LEFT JOIN transactions t ON c.id = t.compte_id
GROUP BY c.id;

-- Vue : Situation des gains (frais retrait et transfert)
CREATE VIEW IF NOT EXISTS vue_situation_gains AS
SELECT
    to2.nom AS type_operation,
    COUNT(t.id) AS nombre_operations,
    COALESCE(SUM(t.montant), 0) AS total_montant,
    COALESCE(SUM(t.frais), 0) AS total_frais
FROM transactions t
JOIN types_operations to2 ON t.type_operation_id = to2.id
WHERE to2.nom IN ('Retrait', 'Transfert')
GROUP BY to2.nom;

-- ============================================
-- DONNEES INITIALES
-- ============================================

-- Admin par defaut : login=admin, mot de passe=admin123
INSERT INTO admins (login, password) VALUES ('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- Prefixes autorises
INSERT INTO prefixes (prefixe, actif) VALUES ('033', 1);
INSERT INTO prefixes (prefixe, actif) VALUES ('037', 1);

-- Types d'operations
INSERT INTO types_operations (nom, description, actif) VALUES ('Depot', 'Depot d argent sur le compte', 1);
INSERT INTO types_operations (nom, description, actif) VALUES ('Retrait', 'Retrait d argent du compte', 1);
INSERT INTO types_operations (nom, description, actif) VALUES ('Transfert', 'Transfert d argent vers un autre compte', 1);

-- Baremes de frais pour Retrait
INSERT INTO baremes_frais (type_operation_id, montant_min, montant_max, frais_fixe) VALUES (2, 100, 1000, 50);
INSERT INTO baremes_frais (type_operation_id, montant_min, montant_max, frais_fixe) VALUES (2, 1001, 5000, 50);
INSERT INTO baremes_frais (type_operation_id, montant_min, montant_max, frais_fixe) VALUES (2, 5001, 10000, 100);
INSERT INTO baremes_frais (type_operation_id, montant_min, montant_max, frais_fixe) VALUES (2, 10001, 25000, 200);
INSERT INTO baremes_frais (type_operation_id, montant_min, montant_max, frais_fixe) VALUES (2, 25001, 50000, 400);
INSERT INTO baremes_frais (type_operation_id, montant_min, montant_max, frais_fixe) VALUES (2, 50001, 100000, 800);
INSERT INTO baremes_frais (type_operation_id, montant_min, montant_max, frais_fixe) VALUES (2, 100001, 250000, 1500);
INSERT INTO baremes_frais (type_operation_id, montant_min, montant_max, frais_fixe) VALUES (2, 250001, 500000, 1500);
INSERT INTO baremes_frais (type_operation_id, montant_min, montant_max, frais_fixe) VALUES (2, 500001, 1000000, 2500);
INSERT INTO baremes_frais (type_operation_id, montant_min, montant_max, frais_fixe) VALUES (2, 1000001, 2000000, 3000);

-- Baremes de frais pour Transfert
INSERT INTO baremes_frais (type_operation_id, montant_min, montant_max, frais_fixe) VALUES (3, 100, 1000, 50);
INSERT INTO baremes_frais (type_operation_id, montant_min, montant_max, frais_fixe) VALUES (3, 1001, 5000, 50);
INSERT INTO baremes_frais (type_operation_id, montant_min, montant_max, frais_fixe) VALUES (3, 5001, 10000, 100);
INSERT INTO baremes_frais (type_operation_id, montant_min, montant_max, frais_fixe) VALUES (3, 10001, 25000, 200);
INSERT INTO baremes_frais (type_operation_id, montant_min, montant_max, frais_fixe) VALUES (3, 25001, 50000, 400);
INSERT INTO baremes_frais (type_operation_id, montant_min, montant_max, frais_fixe) VALUES (3, 50001, 100000, 800);
INSERT INTO baremes_frais (type_operation_id, montant_min, montant_max, frais_fixe) VALUES (3, 100001, 250000, 1500);
INSERT INTO baremes_frais (type_operation_id, montant_min, montant_max, frais_fixe) VALUES (3, 250001, 500000, 1500);
INSERT INTO baremes_frais (type_operation_id, montant_min, montant_max, frais_fixe) VALUES (3, 500001, 1000000, 2500);
INSERT INTO baremes_frais (type_operation_id, montant_min, montant_max, frais_fixe) VALUES (3, 1000001, 2000000, 3000);