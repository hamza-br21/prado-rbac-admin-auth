

CREATE TABLE IF NOT EXISTS profiles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    label VARCHAR(255) NOT NULL,
    active BOOLEAN NOT NULL DEFAULT TRUE
);

INSERT INTO profiles (label, active) VALUES
('Admin', TRUE),
('Manager', TRUE),
('User', TRUE);


CREATE TABLE IF NOT EXISTS habilitations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    label VARCHAR(255) NOT NULL,
    active BOOLEAN NOT NULL DEFAULT TRUE
);


INSERT INTO habilitations (label, active) VALUES
('CREATE_USER', TRUE),
('DELETE_USER', TRUE),
('EDIT_USER', TRUE),
('VIEW_USER', TRUE);




CREATE TABLE IF NOT EXISTS profile_habilitation (
    id_profile INT NOT NULL,
    id_habilitation INT NOT NULL,
    PRIMARY KEY (id_profile, id_habilitation),
    FOREIGN KEY (id_profile) REFERENCES profiles(id) ON DELETE CASCADE,
    FOREIGN KEY (id_habilitation) REFERENCES habilitations(id) ON DELETE CASCADE
);

-- Manager peut voir et modifier
-- Admin a tous les droits
-- User peut seulement voir

INSERT INTO profile_habilitation (id_profile , id_habilitation) VALUES
(1, 1),
(1, 2), 
(1, 3),
(1, 4),
(2, 3),
(2, 4),
(3, 4);



CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL DEFAULT '123456',
    id_profile INT,
    active BOOLEAN NOT NULL DEFAULT TRUE,
    FOREIGN KEY (id_profile) REFERENCES profiles(id)
);



INSERT INTO users (nom, email, id_profile, active) VALUES
('hamza', 'hamza@example.com', 1, TRUE),
('othmane', 'othmane@example.com', 3, TRUE),
('abderrafia', 'abderrafia@example.com', 3, TRUE),
('ilyass', 'ilyass@example.com', 3, TRUE),
('faissal', 'faissal@example.com', 3, TRUE),
('oussama', 'oussama@example.com', 2, TRUE),
('khalid', 'khalid@example.com', 2, TRUE),
('mohamed', 'mohamed@example.com', 2, TRUE),
('soufiane', 'soufiane@example.com', 2, TRUE),
('fatimazahra', 'fatimazahra@example.com', 3, TRUE),
('donia', 'donia@example.com', 3, TRUE),
('douae', 'douae@example.com', 3, TRUE),
('akram', 'akrame@example.com', 2, TRUE),
('ayoub', 'ayoub@example.com', 2, TRUE),
('aissam', 'aissam@example.com', 3, TRUE);


UPDATE users SET password = '$2a$12$GGkG6YO0df.DHrMyGWXCWuvvMspJR1.CZ1qLKqIcXiElzGUP8EKHe' WHERE email = 'hamza@example.com';
UPDATE users SET password = '$2a$12$WfiCdpR.YhOsb6ZIHwRG4.5SAMP/RS7j4dDUUrkJRdHQ2tTvff1TG' WHERE email = 'khalid@example.com';
UPDATE users SET password = '$2a$12$sQVgrCO8KCbl5LUGwwI7eu49cPN.QKDKLBldeiOe6N2uk2jANs8Ky' WHERE email = 'othmane@example.com';
