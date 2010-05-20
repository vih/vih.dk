ALTER TABLE aarsskrift ENGINE = InnoDB;
ALTER TABLE aarsskrift_tekst ENGINE = InnoDB;
ALTER TABLE adresse ENGINE = InnoDB;
ALTER TABLE ansat ENGINE = InnoDB;
ALTER TABLE ansat_funktion ENGINE = InnoDB;
ALTER TABLE ansat_x_fag ENGINE = InnoDB;
ALTER TABLE betaling ENGINE = InnoDB;
ALTER TABLE betaling_online ENGINE = InnoDB;
ALTER TABLE brugervurdering ENGINE = InnoDB;
ALTER TABLE brugervurdering_hvor ENGINE = InnoDB;
ALTER TABLE core_translation_i18n ENGINE = InnoDB;
ALTER TABLE core_translation_langs ENGINE = InnoDB;
ALTER TABLE dankort_payment ENGINE = InnoDB;
ALTER TABLE dbquery_result ENGINE = InnoDB;
ALTER TABLE dokumenter ENGINE = InnoDB;
ALTER TABLE elevforeningen_elevstaevne ENGINE = InnoDB;
ALTER TABLE elevforeningen_jubilar ENGINE = InnoDB;
ALTER TABLE elevforeningen_medlemskartotek ENGINE = InnoDB;
ALTER TABLE elevudtalelse ENGINE = InnoDB;
ALTER TABLE facilitet ENGINE = InnoDB;
ALTER TABLE facilitet_kategori ENGINE = InnoDB;
ALTER TABLE filehandler_append_file ENGINE = InnoDB;
ALTER TABLE file_handler ENGINE = InnoDB;
ALTER TABLE file_handler_instance ENGINE = InnoDB;
ALTER TABLE file_handler_instance_type ENGINE = InnoDB;
ALTER TABLE fotogalleri ENGINE = InnoDB;
ALTER TABLE historik ENGINE = InnoDB;
ALTER TABLE keyword ENGINE = InnoDB;
ALTER TABLE keyword_x_object ENGINE = InnoDB;
ALTER TABLE kortkursus ENGINE = InnoDB;
ALTER TABLE kortkursus_betaling ENGINE = InnoDB;
ALTER TABLE kortkursus_brev ENGINE = InnoDB;
ALTER TABLE kortkursus_deltager_ny ENGINE = InnoDB;
ALTER TABLE kortkursus_deltager_oplysninger_ny ENGINE = InnoDB;
ALTER TABLE kortkursus_tilmelding ENGINE = InnoDB;
ALTER TABLE kortkursus_tilmelding_oplysninger ENGINE = InnoDB;
ALTER TABLE kortkursus_x_indkvartering ENGINE = InnoDB;
ALTER TABLE kunst ENGINE = InnoDB;
ALTER TABLE kursuscenter_evaluering ENGINE = InnoDB;
ALTER TABLE langtkursus ENGINE = InnoDB;
ALTER TABLE langtkursus_fag ENGINE = InnoDB;
ALTER TABLE langtkursus_fag_gruppe ENGINE = InnoDB;
ALTER TABLE langtkursus_fag_periode ENGINE = InnoDB;
ALTER TABLE langtkursus_rate ENGINE = InnoDB;
ALTER TABLE langtkursus_tilmelding ENGINE = InnoDB;
ALTER TABLE langtkursus_tilmelding_protokol_item ENGINE = InnoDB;
ALTER TABLE langtkursus_tilmelding_rate ENGINE = InnoDB;
ALTER TABLE langtkursus_tilmelding_x_fag ENGINE = InnoDB;
ALTER TABLE langtkursus_x_fag ENGINE = InnoDB;
ALTER TABLE langtkursus_x_file ENGINE = InnoDB;
ALTER TABLE langtkursus_x_tema ENGINE = InnoDB;
ALTER TABLE nyhed ENGINE = InnoDB;
ALTER TABLE nyhed_x_file ENGINE = InnoDB;
ALTER TABLE redirect ENGINE = InnoDB;
ALTER TABLE redirect_parameter ENGINE = InnoDB;
ALTER TABLE langtkursus_tilmelding ENGINE = InnoDB;
ALTER TABLE venteliste ENGINE = InnoDB;
ALTER TABLE materialebestilling ENGINE = InnoDB;
ALTER TABLE redirect_parameter_value ENGINE = InnoDB;
ALTER TABLE v_i_h__model__course__period ENGINE = InnoDB;
ALTER TABLE v_i_h__model__course__registration__subject ENGINE = InnoDB;
ALTER TABLE v_i_h__model__course__subject_group ENGINE = InnoDB;
ALTER TABLE v_i_h__model__course__subject_group__subject ENGINE = InnoDB;

ALTER TABLE ansat_x_fag
ADD FOREIGN KEY (ansat_id) REFERENCES ansat(id);
ALTER TABLE ansat_x_fag
ADD FOREIGN KEY (fag_id) REFERENCES langtkursus_fag(id);
ALTER TABLE keyword_x_object
ADD FOREIGN KEY (keyword_id) REFERENCES keyword(id);
ALTER TABLE keyword_x_object
ADD FOREIGN KEY (keyword_id) REFERENCES keyword(id);

ALTER TABLE kortkursus_betaling
ADD FOREIGN KEY (tilmelding_id) REFERENCES kortkursus_tilmelding(id);
ALTER TABLE kortkursus_deltager_ny
ADD FOREIGN KEY (tilmelding_id) REFERENCES kortkursus_tilmelding(id);
ALTER TABLE kortkursus_deltager_oplysninger_ny
ADD FOREIGN KEY (deltager_id) REFERENCES kortkursus_deltager_ny(id);
ALTER TABLE kortkursus_tilmelding_oplysninger
ADD FOREIGN KEY (tilmelding_id) REFERENCES kortkursus_tilmelding(id);
ALTER TABLE kortkursus_x_indkvartering
ADD FOREIGN KEY (kursus_id) REFERENCES kortkursus(id);

ALTER TABLE langtkursus_tilmelding
ADD FOREIGN KEY (kursus_id) REFERENCES langtkursus(id);
ALTER TABLE langtkursus_rate
ADD FOREIGN KEY (langtkursus_id) REFERENCES langtkursus(id);
ALTER TABLE langtkursus_tilmelding_protokol_item
ADD FOREIGN KEY (tilmelding_id) REFERENCES langtkursus_tilmelding(id);

ALTER TABLE redirect_parameter
ADD FOREIGN KEY (redirect_id) REFERENCES redirect(id);
ALTER TABLE redirect_parameter_value
ADD FOREIGN KEY (redirect_id) REFERENCES redirect(id);



DROP TABLE `brugervurdering`, `brugervurdering_hvor`, `kursuscenter_evaluering`, `liveuser_applications`, `liveuser_areas`, `liveuser_grouprights`, `liveuser_groups`, `liveuser_groupusers`, `liveuser_rights`, `liveuser_userrights`, `ost_config`, `ost_department`, `ost_email`, `ost_email_banlist`, `ost_email_pop3`, `ost_email_template`, `ost_groups`, `ost_help_topic`, `ost_kb_premade`, `ost_staff`, `ost_ticket`, `ost_ticket_attachment`, `ost_ticket_lock`, `ost_ticket_message`, `ost_ticket_note`, `ost_ticket_priority`, `ost_ticket_response`, `ost_timezone`, `ticket`;

DROP TABLE `dankort_payment`, `kortkursus_betaling`;

DROP TABLE `dokumenter`, `elevforeningen_elevstaevne`, `elevforeningen_medlemskartotek`, `langtkursus_fag_periode`, `langtkursus_tilmelding_x_fag`, `langtkursus_x_fag`, `langtkursus_x_file`, `langtkursus_x_tema`;
