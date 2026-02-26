

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
('hamza', 'hamza@gmail.com', 1, TRUE),
('othmane', 'othmane@gmail.com', 3, TRUE),
('abderrafia', 'abderrafia@gmail.com', 3, TRUE),
('ilyass', 'ilyass@gmail.com', 3, TRUE),
('faissal', 'faissal@gmail.com', 3, TRUE),
('oussama', 'oussama@gmail.com', 2, TRUE),
('khalid', 'khalid@gmail.com', 2, TRUE),
('mohamed', 'mohamed@gmail.com', 2, TRUE),
('soufiane', 'soufiane@gmail.com', 2, TRUE),
('yassine', 'yassine@gmail.com', 2, TRUE),
('fatimazahra', 'fatimazahra@gmail.com', 3, TRUE),
('donia', 'donia@gmail.com', 3, TRUE),
('douae', 'douae@gmail.com', 3, TRUE),
('akram', 'akram@gmail.com', 2, TRUE),
('ayoub', 'ayoub@gmail.com', 2, TRUE),
('aissam', 'aissam@gmail.com', 3, TRUE),
('ahlam', 'ahlam@gmail.com', 3, TRUE),
('imane', 'imane@gmail.com', 3, TRUE),
('ihssane', 'ihssane@gmail.com', 3, TRUE),
('marouane', 'marouane@gmail.com', 2, TRUE),
('douha', 'douha@gmail.com', 3, TRUE);


UPDATE users SET password = '$2a$12$GGkG6YO0df.DHrMyGWXCWuvvMspJR1.CZ1qLKqIcXiElzGUP8EKHe' WHERE email = 'hamza@gmail.com';
UPDATE users SET password = '$2a$12$WfiCdpR.YhOsb6ZIHwRG4.5SAMP/RS7j4dDUUrkJRdHQ2tTvff1TG' WHERE email = 'khalid@gmail.com';
UPDATE users SET password = '$2a$12$WfiCdpR.YhOsb6ZIHwRG4.5SAMP/RS7j4dDUUrkJRdHQ2tTvff1TG' WHERE email = 'soufiane@gmail.com';
UPDATE users SET password = '$2a$12$sQVgrCO8KCbl5LUGwwI7eu49cPN.QKDKLBldeiOe6N2uk2jANs8Ky' WHERE email = 'othmane@gmail.com';
UPDATE users SET password = '$2a$12$sQVgrCO8KCbl5LUGwwI7eu49cPN.QKDKLBldeiOe6N2uk2jANs8Ky' WHERE email = 'ilyass@gmail.com';
UPDATE users SET password = '$2a$12$sQVgrCO8KCbl5LUGwwI7eu49cPN.QKDKLBldeiOe6N2uk2jANs8Ky' WHERE email = 'faissal@gmail.com';
UPDATE users SET password = '$2a$12$sQVgrCO8KCbl5LUGwwI7eu49cPN.QKDKLBldeiOe6N2uk2jANs8Ky' WHERE email = 'abderrafia@gmail.com';
UPDATE users SET password = '$2a$12$sQVgrCO8KCbl5LUGwwI7eu49cPN.QKDKLBldeiOe6N2uk2jANs8Ky' WHERE email = 'douha@gmail.com';