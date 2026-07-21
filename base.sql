-- =====================================================
-- Base de donnees : Mobile Money Simulator
-- Projet examen S4 Info et Design - Juillet 2026
-- Binome : ETU004276 et ETU004281
-- =====================================================

-- Table des prefixes valides de l'opprateur
CREATE TABLE IF NOT EXISTS prefices (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    prefixe TEXT NOT NULL UNIQUE,
    statut INTEGER DEFAULT 1,
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Donnees initiales des prefixes
INSERT INTO prefices (prefixe) VALUES ('033'), ('037');

-- Table des types d'operations
CREATE TABLE IF NOT EXISTS types_operations (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    code TEXT NOT NULL UNIQUE,
    libelle TEXT NOT NULL
);

-- Donnees initiales des types d'operations
INSERT INTO types_operations (code, libelle) VALUES
    ('depot', 'Depot'),
    ('retrait', 'Retrait'),
    ('transfert', 'Transfert');

-- Table des baremes de frais par tranche de montant
CREATE TABLE IF NOT EXISTS baremes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    id_type_operation INTEGER NOT NULL,
    montant_min REAL NOT NULL,
    montant_max REAL NOT NULL,
    frais_fixe REAL DEFAULT 0,
    frais_pourcentage REAL DEFAULT 0,
    FOREIGN KEY (id_type_operation) REFERENCES types_operations(id)
);

-- Baremes pour les retraits
INSERT INTO baremes (id_type_operation, montant_min, montant_max, frais_fixe, frais_pourcentage) VALUES
    (2, 0, 1000, 50, 0),
    (2, 1001, 5000, 100, 1),
    (2, 5001, 20000, 200, 2),
    (2, 20001, 100000, 500, 3);

-- Baremes pour les transferts
INSERT INTO baremes (id_type_operation, montant_min, montant_max, frais_fixe, frais_pourcentage) VALUES
    (3, 0, 1000, 25, 0),
    (3, 1001, 5000, 50, 0.5),
    (3, 5001, 20000, 100, 1),
    (3, 20001, 100000, 200, 1.5);

-- Table des clients
CREATE TABLE IF NOT EXISTS clients (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    telephone TEXT NOT NULL UNIQUE,
    nom TEXT DEFAULT '',
    solde REAL DEFAULT 0,
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Donnees initiales de clients pour les tests
INSERT INTO clients (telephone, nom, solde) VALUES
    ('0330000001', 'Rakoto', 50000),
    ('0330000002', 'Rasoa', 30000),
    ('0370000001', 'Rabe', 25000);

-- Table des transactions
CREATE TABLE IF NOT EXISTS transactions (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    id_client INTEGER NOT NULL,
    type_operation TEXT NOT NULL,
    montant REAL NOT NULL,
    frais REAL DEFAULT 0,
    montant_total REAL DEFAULT 0,
    destinataire TEXT DEFAULT NULL,
    batch_id TEXT DEFAULT NULL,
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_client) REFERENCES clients(id)
);

-- Table des operateurs externes
CREATE TABLE IF NOT EXISTS operateurs_externes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom TEXT NOT NULL,
    prefixe TEXT NOT NULL,
    commission_pct REAL DEFAULT 0,
    actif INTEGER DEFAULT 1,
    date_creation TEXT DEFAULT CURRENT_TIMESTAMP
);

-- Donnees initiales des operateurs externes
INSERT INTO operateurs_externes (nom, prefixe, commission_pct, actif) VALUES
    ('Airtel', '032', 2, 1),
    ('Telma', '034', 1.5, 1),
    ('Bip', '031', 1, 1);
