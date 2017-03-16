
CREATE DATABASE tableManagerSample;

CREATE TABLE tableManagerSample.people
(
  id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  first VARCHAR(255) NOT NULL,
  last VARCHAR(255) NOT NULL,
  age INT(3) NOT NULL,
  sex ENUM('Agender', 'Androgyne', 'Androgynous', 'Bigender', 'Cis', 'Cisgender', 'Cis Female', 'Cis Male', 'Cis Man', 'Cis Woman', 'Cisgender Female', 'Cisgender Male', 'Cisgender Man', 'Cisgender Woman', 'Female to Male', 'FTM', 'Gender Fluid', 'Gender Nonconforming', 'Gender Questioning', 'Gender Variant', 'Genderqueer', 'Intersex', 'Male to Female', 'MTF', 'Neither', 'Neutrois', 'Non-binary', 'Other', 'Pangender', 'Trans', 'Trans*', 'Trans Female', 'Trans* Female', 'Trans Male', 'Trans* Male', 'Trans Man', 'Trans* Man', 'Trans Person', 'Trans* Person', 'Trans Woman', 'Trans* Woman', 'Transfeminine', 'Transgender', 'Transgender Female', 'Transgender Male', 'Transgender Man', 'Transgender Person', 'Transgender Woman', 'Transmasculine', 'Transsexual', 'Transsexual Female', 'Transsexual Male', 'Transsexual Man', 'Transsexual Person', 'Transsexual Woman', 'Two-Spirit') NOT NULL,
  comment TEXT
);
CREATE UNIQUE INDEX people_id_uindex ON tableManagerSample.people (id);
ALTER TABLE tableManagerSample.people COMMENT = 'thanks facebook!';