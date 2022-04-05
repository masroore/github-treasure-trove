# ************************************************************
# Sequel Pro SQL dump
# Versión 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.7.25)
# Base de datos: babypassport
# Tiempo de Generación: 2020-03-08 04:00:51 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Volcado de tabla advertising
# ------------------------------------------------------------

DROP TABLE IF EXISTS `advertising`;

CREATE TABLE `advertising` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `published_at` datetime NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `advertising_title_unique` (`title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `advertising` WRITE;
/*!40000 ALTER TABLE `advertising` DISABLE KEYS */;

INSERT INTO `advertising` (`id`, `title`, `content`, `image`, `url`, `published_at`, `expires_at`, `status`, `created_at`, `updated_at`)
VALUES
	(1,'Vendete al mejor postor','Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab animi architecto blanditiis cum doloribus ducimus eaque, eligendi eos illum in incidunt, maiores minima molestiae nam nesciunt nisi sed suscipit vitae?','bruker_nucleo_presentacion_2.jpg','https://www.youtube.com/watch?v=yjdk8bZFWLE','2019-06-15 00:00:00',NULL,1,'2019-06-18 12:33:18','2019-06-18 12:59:54');

/*!40000 ALTER TABLE `advertising` ENABLE KEYS */;
UNLOCK TABLES;


# Volcado de tabla blog
# ------------------------------------------------------------

DROP TABLE IF EXISTS `blog`;

CREATE TABLE `blog` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `poster_intro` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `intro` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `poster_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `detail_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `date_to_publish` datetime NOT NULL,
  `date_to_expire` datetime DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `blog` WRITE;
/*!40000 ALTER TABLE `blog` DISABLE KEYS */;

INSERT INTO `blog` (`id`, `title`, `poster_intro`, `intro`, `poster_image`, `detail_image`, `date_to_publish`, `date_to_expire`, `status`, `created_at`, `updated_at`)
VALUES
	(34,'Los beneficios de nacer en Estados Unidos','Los beneficios de nacer en Estados Unidos','<h2 dir=\"ltr\">Reg&aacute;lale a tu hijo la ciudadan&iacute;a americana&nbsp;</h2>','inc.png','combinado.png','2020-03-06 00:00:00',NULL,1,'2020-03-06 12:29:37','2020-03-06 12:33:22');

/*!40000 ALTER TABLE `blog` ENABLE KEYS */;
UNLOCK TABLES;


# Volcado de tabla blog_category
# ------------------------------------------------------------

DROP TABLE IF EXISTS `blog_category`;

CREATE TABLE `blog_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `blog_id` int(10) unsigned NOT NULL,
  `category_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `blog_category_blog_id_foreign` (`blog_id`),
  KEY `blog_category_category_id_foreign` (`category_id`),
  CONSTRAINT `blog_category_blog_id_foreign` FOREIGN KEY (`blog_id`) REFERENCES `blog` (`id`) ON DELETE CASCADE,
  CONSTRAINT `blog_category_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `blog_category` WRITE;
/*!40000 ALTER TABLE `blog_category` DISABLE KEYS */;

INSERT INTO `blog_category` (`id`, `blog_id`, `category_id`, `created_at`, `updated_at`)
VALUES
	(32,34,1,'2020-03-06 12:29:37','2020-03-06 12:29:37');

/*!40000 ALTER TABLE `blog_category` ENABLE KEYS */;
UNLOCK TABLES;


# Volcado de tabla blog_tag
# ------------------------------------------------------------

DROP TABLE IF EXISTS `blog_tag`;

CREATE TABLE `blog_tag` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `blog_id` int(10) unsigned NOT NULL,
  `tag_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `blog_tag_blog_id_foreign` (`blog_id`),
  KEY `blog_tag_tag_id_foreign` (`tag_id`),
  CONSTRAINT `blog_tag_blog_id_foreign` FOREIGN KEY (`blog_id`) REFERENCES `blog` (`id`) ON DELETE CASCADE,
  CONSTRAINT `blog_tag_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `blog_tag` WRITE;
/*!40000 ALTER TABLE `blog_tag` DISABLE KEYS */;

INSERT INTO `blog_tag` (`id`, `blog_id`, `tag_id`, `created_at`, `updated_at`)
VALUES
	(170,34,22,'2020-03-06 12:33:22','2020-03-06 12:33:22');

/*!40000 ALTER TABLE `blog_tag` ENABLE KEYS */;
UNLOCK TABLES;


# Volcado de tabla blog_topic
# ------------------------------------------------------------

DROP TABLE IF EXISTS `blog_topic`;

CREATE TABLE `blog_topic` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `blog_id` int(10) unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `blog_topic_blog_id_foreign` (`blog_id`),
  CONSTRAINT `blog_topic_blog_id_foreign` FOREIGN KEY (`blog_id`) REFERENCES `blog` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `blog_topic` WRITE;
/*!40000 ALTER TABLE `blog_topic` DISABLE KEYS */;

INSERT INTO `blog_topic` (`id`, `blog_id`, `title`, `content`, `created_at`, `updated_at`)
VALUES
	(70,34,'Regálale a tu hijo la ciudadanía americana','<p dir=\"ltr\">&iexcl;Te felicitamos! Has tomado una decisión muy sabia.</p><p dir=\"ltr\">Al regalarle la&nbsp;<a href=\"https://www.usa.gov/espanol/naturalizacion\">nacionalidad americana</a> a tu bebé, le estás dando una de las ventajas más grandes que podría tener al nacer:</p><p dir=\"ltr\">Nacer con nacionalidad americana es como jugar la vida en modo fácil, porque obtienes varios beneficios:</p><p dir=\"ltr\">- Hacer dinero en EU, es mucho más fácil que en cualquier país del mundo. Es por eso que tanta gente busca oportunidades laborales en dicho país, ya sea de manera temporal o permanente.</p><p dir=\"ltr\">- Es un país seguro. No tiene estados completamente controlados por el narcotráfico, grupos de presion, o ciudadanos extorsionados por la autoridad policial que debería velar por su seguridad, a diferencia de México.</p><p><br></p><p dir=\"ltr\">Esto, ha hecho que muchos padres, pensando en el bienestar de sus futuros hijos, viajen a Estados Unidos exclusivamente para tener su parto y brindarle a su bebé, la naciona-</p><p dir=\"ltr\">lidad americana.</p><p dir=\"ltr\">Sólo se les ha presentado un pequeñísimo obstáculo.</p>','2020-03-06 12:29:37','2020-03-06 12:33:22'),
	(71,34,'¿Cómo tener a tu bebé en estados unidos sin arriesgar tu vida?','<p dir=\"ltr\">La gran mayoría de padres, no tiene idea de cómo funcionan los hospitales en estados unidos, ni de todos los procesos legales por los que tienen que pasar.</p><p><br></p><p dir=\"ltr\">Y ni los hospitales, ni los doctores, contestan todas sus dudas.</p><p dir=\"ltr\">Después de todo, su trabajo es brindar servicio médico de calidad, y no ser agentes aduanales o asesores de viaje.</p><p dir=\"ltr\">De hecho, actualmente muchos médicos prefieren evitar tratar con padres latinos que buscan dar a luz en Estados Unidos, porque llegan con demasiadas dudas y las constantes llamadas para contestar preguntas legales toman mucho tiempo del doctor.</p>','2020-03-06 12:29:37','2020-03-06 12:33:22'),
	(72,34,'El testimonio de una familia mexicana que dio a luz en estados unidos con visa de turista','<p dir=\"ltr\">Esto es lo que vivío un miembro de la familia fundadora&nbsp;<a href=\"https://thebabypassport.com/\">Baby Passport</a>, hace ya 5 años.</p><p dir=\"ltr\">&ldquo;Sabíamos que era posible tener a nuestro hijo en Estados Unidos. Habíamos escuchado historias de éxito de algunos conocidos, pero también habíamos escuchado historias de horror:</p><p dir=\"ltr\">Agentes fronterizos que destrozaban VISAS de mujeres visiblemente embarazadas.</p><p dir=\"ltr\">Padres que tenían a su bebé, regresaban a México y cuando intentaban renovar la VISA... &ldquo;Denegada&rdquo;.</p><p dir=\"ltr\">Definitivamente queríamos tener a nuestro hijo allá, pero no queríamos pasar por nada de eso.</p><p><br></p><p><br></p><p dir=\"ltr\">Para complicar aún más las cosas, cuando hablábamos a los hospitales para pedir información, sólo nos podían cotizar el costo de las instalaciones. Es decir, no incluían a los doctores en sus paquetes y nos decían que debíamos buscarlos por nuestra cuenta.</p><p dir=\"ltr\">Ya estábamos en la semana 34, no teníamos un doctor y todavía nos quedaban muchas dudas de lo que pasaría cuando intentáramos cruzar la frontera.</p><p dir=\"ltr\">La verdad es que mi esposo y yo, nos estábamos desanimando y por momentos pensamos en tirar la toalla y tener a nuestro hijo en México.</p>','2020-03-06 12:29:37','2020-03-06 12:33:22'),
	(73,34,'Baby Passport: Tu aliado para tener un parto seguro en los usa','<p dir=\"ltr\">Una prima, se enteró de nuestro plan para tener a nuestro hijo en Estados Unidos y nos ofreció su ayuda. Nos presentó a una amiga suya, que ya había tenido a sus 2 bebés en El Paso, Texas.</p><p dir=\"ltr\">Su amiga nos explicó exactamente lo que teníamos que decir a los agentes de migración; a qué doctores buscar, dónde hospedarnos, cuáles papeles llevar para todos los trámites legales y administrativos y qué debíamos evitar.</p><p dir=\"ltr\">Nos contó que lo que más molestaba al gobierno americano, son los turistas deudores. Es decir, padres que iban a Estados Unidos, tenían a su bebé y no pagaban ni un centavo al hospital, obligando al seguro del gobiernos absorber ese gasto, convirtiéndote en una carga para el país.</p><p dir=\"ltr\">Como consecuencia, cancelan tu VISA para que no puedas volver a hacerlo y dificilmente, podrás tenerla nuevamente.</p><p dir=\"ltr\">Nos explicó que al llegar a aduana, con tu recibo de pago del hospital todo se vuelve mucho más fácil.</p><p dir=\"ltr\">Además, nos recomendó al doctor que la atendió en sus dos partos. Hablamos con él, y nos ayudó a conseguir todos los médicos que necesitaríamos.</p><p dir=\"ltr\">En su consultorio, le preguntamos por qué los doctores y los hospitales dan tan poca información, a lo que respondió:</p><p dir=\"ltr\">&ldquo;Porque la mayoría de los padres latinos tienen demasiadas dudas legales, por las que me llaman y mandan Whatsapps 3 veces al día. Ningún doctor quiere encargarse de eso, porque no es su trabajo.&rdquo;</p><p dir=\"ltr\">&iexcl;Ahora todo tenía sentido!</p><p dir=\"ltr\">Lo bueno es que nuestra nueva amiga ya nos había dado toda la información que necesitábamos. Pasamos de estar estresados todo el día y no poder dormir por las noche, a relajarnos al fin, sabiendo que todo saldría bien.</p><p dir=\"ltr\">Finalmente, el 16 de Junio nació nuestro hijo en El Paso, Texas.</p>','2020-03-06 12:29:37','2020-03-06 12:33:22'),
	(74,34,'Requisitos para registrar a un bebé nacido en Estados Unidos.','<p dir=\"ltr\">Ya habíamos pagado, así que no tuvimos ningún problema con el hospital. Seguimos las indicaciones de nuestra amiga, y tramitamos los papeles de nuestro bebé. Un mes después, estábamos de regreso en Querétaro con todos los papeles. Nuestro hijo era un ciudadano americano. Renovamos nuestra VISA 8 meses después, y nos la aprobaron sin problema alguno.</p><p dir=\"ltr\">Unos meses después, amigas mías se enteraron de que nuestro hijo había nacido en Estados Unidos y nos pidieron ayuda.</p><p dir=\"ltr\">Las ayudamos, y ellas a su vez nos traían a más de sus amigas, con el mismo deseo para sus hijos.</p><p dir=\"ltr\">Nos dimos cuenta de que había muchos padres en la misma situación en la que nos encontrabamos meses atrás, y así surgió la idea del Programa&nbsp;<a href=\"https://thebabypassport.com/\">Baby Passport.</a></p><p><br></p><p dir=\"ltr\">El año pasado ayudamos a 1,217 parejas a tener a su bebé en Estados Unidos.</p><p dir=\"ltr\">Con Baby Passport, ayudamos a padres de toda Latinoamérica a encontrar a sus doctores</p><p><br></p><p dir=\"ltr\">Al día de hoy tenemos alianzas con diversos grupos médicos en El Paso, McAllen, Dallas, Phoenix y San Francisco. Ayudamos a las parejas a navegar por todos los procedimientos legales que todavía no conocen.</p><p dir=\"ltr\">Nuestro objetivo es quitarles esa preocupación en su embarazo. Después de todo, un embarazo por sí sólo conlleva cierto estrés.</p><p dir=\"ltr\">Si quieres conocer más sobre nuestro programa, haz click aquí:</p>','2020-03-06 12:29:37','2020-03-06 12:33:22'),
	(75,34,'Clínicas de maternidad en el Paso, Texas','<p dir=\"ltr\">Por cierto, en estos 5 años de experiencia hemos aprendido bastante.</p><p dir=\"ltr\">Y resulta que el lugar dónde tuvimos a nuestro hijo,&nbsp;<a href=\"https://www.google.com/maps/place/El+Paso,+Texas,+EE.+UU./@31.8108262,-106.7047064,10z/data=!3m1!4b1!4m5!3m4!1s0x86e73f8bc5fe3b69:0xe39184e3ab9d0222!8m2!3d31.7618778!4d-106.4850217\">El Paso, Texas</a>, es la opción más económica de todas.</p><p><br></p><p dir=\"ltr\">Si nos hubiéramos decidido por otro lado hubiéramos pagado de más. Así que corrimos con bastante suerte.</p><p dir=\"ltr\">Esto es porque el costo de vida en El Paso es bajo, comparado con otras ciudades de Estados Unidos.</p><p dir=\"ltr\">Otro dato que descubrimos en estos 5 años, es que el trato mejora en los hospitales cuando llegas con tu recibo de pago, porque se aseguran de que no serás un turista deudor.</p><p dir=\"ltr\">Y lo más importante:</p><p dir=\"ltr\">Una mujer embarazada debe tener la menor cantidad de estrés posible.</p><p dir=\"ltr\">Es de vital importancia. Descubrimos que el estrés se transmite al bebé por medio del líquido amniótico y un embarazo con demasiado estrés, aumenta la probabilidad de un parto con complicaciones, uso de incubadora y otros cuidados extensivos, que son caros, honestamente.&rdquo;</p>','2020-03-06 12:29:37','2020-03-06 12:33:22'),
	(76,34,'¿Cómo Baby Passport te puede ayudar a tener un parto en Estados Unidos?','<p dir=\"ltr\">En Baby Passport contamos con experiencia de más de 5 años ayudando a parejas latinas</p><p dir=\"ltr\">a cumplir el sueño de regalar a sus hijos un mejor futuro, la nacionalidad americana, que abre la oportunidad de acceder a los mejores beneficios como ciudadano estadounidense.</p><p><br></p><p><br></p><p dir=\"ltr\">Déjalo en nuestras manos, te acompañaremos durante todo el proceso.</p><p><br></p><p><br></p>','2020-03-06 12:29:37','2020-03-06 12:33:22');

/*!40000 ALTER TABLE `blog_topic` ENABLE KEYS */;
UNLOCK TABLES;


# Volcado de tabla cart
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cart`;

CREATE TABLE `cart` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `balance` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `cart` WRITE;
/*!40000 ALTER TABLE `cart` DISABLE KEYS */;

INSERT INTO `cart` (`id`, `user_id`, `amount`, `balance`, `created_at`, `updated_at`)
VALUES
	(72,42,5350.00,5350.00,'2019-07-01 11:11:12','2019-07-01 11:11:12'),
	(73,42,15000.00,15000.00,'2019-07-01 11:17:11','2019-07-01 11:17:11'),
	(74,42,8443.00,8443.00,'2019-07-02 10:52:14','2019-07-02 10:52:14'),
	(75,42,9240.00,9240.00,'2019-10-07 16:32:53','2019-10-07 16:32:53');

/*!40000 ALTER TABLE `cart` ENABLE KEYS */;
UNLOCK TABLES;


# Volcado de tabla cart_item
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cart_item`;

CREATE TABLE `cart_item` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cart_id` int(10) unsigned NOT NULL,
  `hospital_product_id` int(10) unsigned NOT NULL,
  `quantity` int(11) NOT NULL,
  `discount` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cart_item_cart_id_foreign` (`cart_id`),
  KEY `cart_item_hospital_product_id_foreign` (`hospital_product_id`),
  CONSTRAINT `cart_item_cart_id_foreign` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`id`) ON DELETE CASCADE,
  CONSTRAINT `cart_item_hospital_product_id_foreign` FOREIGN KEY (`hospital_product_id`) REFERENCES `hospital_product` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `cart_item` WRITE;
/*!40000 ALTER TABLE `cart_item` DISABLE KEYS */;

INSERT INTO `cart_item` (`id`, `cart_id`, `hospital_product_id`, `quantity`, `discount`, `total`)
VALUES
	(19,72,11,1,NULL,5350.00),
	(20,73,8,1,NULL,15000.00),
	(21,74,14,1,NULL,8443.00),
	(22,75,20,1,NULL,9240.00);

/*!40000 ALTER TABLE `cart_item` ENABLE KEYS */;
UNLOCK TABLES;


# Volcado de tabla cart_payment
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cart_payment`;

CREATE TABLE `cart_payment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cart_id` int(10) unsigned NOT NULL,
  `payment_type` enum('voucher','visa','mastercard','american_express') COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_uuid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `old_balance` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `iva` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `new_balance` decimal(10,2) NOT NULL,
  `receipt` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cart_payment_cart_id_foreign` (`cart_id`),
  CONSTRAINT `cart_payment_cart_id_foreign` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Volcado de tabla category
# ------------------------------------------------------------

DROP TABLE IF EXISTS `category`;

CREATE TABLE `category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `text_color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;

INSERT INTO `category` (`id`, `category`, `color`, `text_color`, `status`, `created_at`, `updated_at`)
VALUES
	(1,'Mamá paso a paso','mandys-pink','white',1,NULL,'2019-03-06 08:56:16'),
	(2,'Recomendaciones','spray','white',1,NULL,'2019-03-05 16:15:56'),
	(3,'Salud y Belleza','ce-soir','white',1,NULL,NULL),
	(4,'Estilo de vida','light','grey-suit',1,NULL,'2019-03-06 09:23:40'),
	(5,'Quitate','spray','grey-suit',0,'2019-03-06 09:23:52','2019-03-06 09:24:17');

/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;


# Volcado de tabla city
# ------------------------------------------------------------

DROP TABLE IF EXISTS `city`;

CREATE TABLE `city` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `copy` text COLLATE utf8mb4_unicode_ci,
  `bg_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `status` tinyint(1) unsigned DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `city` WRITE;
/*!40000 ALTER TABLE `city` DISABLE KEYS */;

INSERT INTO `city` (`id`, `city`, `copy`, `bg_image`, `image`, `status`, `created_at`, `updated_at`, `description`)
VALUES
	(1,'San Diego, California','La octava ciudad más grande de Estados Unidos, San Diego es reconocida por su clima casi perfecto. En San Diego la demanda de empleo sigue creciendo, hay muchas ofertas de trabajo, es una ciudad segura para vivir y es un lugar para adquirir fácil una vivienda. Dale a tu bebé la oportunidad de tener una vida más segura.','bg-sandiego.jpg','1581010830.jpg',1,NULL,'2020-02-06 11:40:30','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. '),
	(2,'El Paso, Texas','La segunda ciudad más importante de la frontera entre Estados Unidos y México, es la ciudad más segura en las urbes de Estados Unidos. Sus habitantes hacen de la ciudad un ambiente cálido y familiar, la gente es muy amigable, existe un gobierno muy amable y hay una buena actitud hacía los negocios. Dale a tu bebé la oportunidad a tu bebé de formar un futuro mejor.','bg-elpaso.jpg','1581010796.jpg',1,NULL,'2020-02-06 11:39:56','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. '),
	(3,'Houston,Texas\n','Una de las ciudades más prósperas del país, existen muchas oportunidades de trabajo. Cuenta con una comunidad científica avanzada en salud, además de que el deporte abunda bastante y es una ciudad con una economía muy avanzada. Imagina a tu bebé tomando estas oportunidades en conjunto de tu familia. Conoce más sobre este paquete.\n','bg-dallas.jpg','1581010728.jpg',1,'2019-03-06 14:32:45','2020-02-06 11:38:48','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. '),
	(4,'McAllen,Texas','La ciudad mayor de su condado, es la tercer ciudad con mayor crecimiento de empleo proyectado cada año. Tiene un gran sistema educativo, cultura y un clima espectacular. McAllen es la séptima ciudad más segura de los estados Unidos. Brindale a tu bebé la oportunidad de obtener la mejor educación  en McAllen.\n','bg-mcallen.jpg','1581010813.jpg',1,'2019-03-06 14:33:23','2020-02-06 11:40:13','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. '),
	(5,'Brownsville,Texas','Una de las mejores ciudades para vivir de acuerdo con sus salarios y costes de vida, esta ciudad es caracterizada por ser un destino multicultural perfecto para vivir tranquilamente. Esta zona fronteriza ofrece diversas opciones en hospedaje, gastronomía, cultura y abundancia de naturaleza e historia. Dale a tu bebé la oportunidad tener un futuro mejor en Brownsville.','bg-brownsville.jpg','1582751406.jpg',1,NULL,'2020-03-04 10:27:03',NULL),
	(6,'brenda',NULL,NULL,'',NULL,NULL,NULL,NULL);

/*!40000 ALTER TABLE `city` ENABLE KEYS */;
UNLOCK TABLES;


# Volcado de tabla hospital
# ------------------------------------------------------------

DROP TABLE IF EXISTS `hospital`;

CREATE TABLE `hospital` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rating_id` int(10) unsigned NOT NULL,
  `city_id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `about` text COLLATE utf8mb4_unicode_ci,
  `appointment_duration` time NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitude` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `photo_one` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo_two` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo_three` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `hospital_rating_id_foreign` (`rating_id`),
  KEY `city_id` (`city_id`),
  CONSTRAINT `hospital_ibfk_1` FOREIGN KEY (`city_id`) REFERENCES `city` (`id`),
  CONSTRAINT `hospital_rating_id_foreign` FOREIGN KEY (`rating_id`) REFERENCES `rating` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `hospital` WRITE;
/*!40000 ALTER TABLE `hospital` DISABLE KEYS */;

INSERT INTO `hospital` (`id`, `rating_id`, `city_id`, `name`, `photo`, `about`, `appointment_duration`, `address`, `latitude`, `longitude`, `phone`, `email`, `created_at`, `updated_at`, `photo_one`, `photo_two`, `photo_three`)
VALUES
	(5,5,1,'Sharp Chula Vista','sharp-chula-vista.jpg','De los hospitales más privilegiados en California por su atención de alto nivel. Está acreditado por el  Programa Nacional de Acreditación para Centros de Mamás, por contar con servicios de excelencia tanto como para mujeres embarazadas y parto, además cuenta con un instituto neonatal dar a los bebés el mejor comienzo de vida. ¡Estarás en manos de enfermeras y médicos altamente capacitados en atención maternal! \n\nLugares cercanos al hospital\nContarás con restaurantes cercanos para que puedas ir a comer en familia, un bello parque para que puedas pasear con tu bebé y tendrás cerca un centro comercial para que puedan salir a distraerse después de recuperarte. Estarás cerca de hoteles muy cómodos para que puedas hospedarte durante tu estancia en Estados Unidos.\n\nImagina este momento \n\n','00:30:00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'SD_SHARP_01.jpg','SD_SHARP_02.jpg','SD_SHARP_03.jpg'),
	(6,5,1,'Paradise Valley Hospital','paradise-valley-hospital.jpg','Una de las muchas razones reconfortantes para tener a su bebé en este centro de atención médico es saber que tu recién nacido será atendido en un hospital que se encuentra entre los 100 mejores hospitales de la nación y el único hospital de San Diego en ser nombrado con el Mejor desempeño en las medidas clave de calidad cinco años consecutivos.\n\nLugares cercanos al hospital\nTendrás un hermoso parque cerca para poder disfrutar de un día agradable con tu bebé, además de diferentes restaurantes para comer como Pho nam cali, Hilberto’s Mexican Food, Los Titos mexican food y más. Cerca de ti también tendrás diferentes lugares para hospedarte y  supermercados en caso de ser necesario.\n\n\n\n','00:30:00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'SD_PARADISE_01.jpg','SD_PARADISE_02.jpg','SD_PARADISE_03.jpg'),
	(7,5,1,'Sharp Mary Birch','sharp-mary-birch.jpg','Es el único hospital de mujeres en el condado de San Diego. Cada año, recibe a casi 8,000 bebés en el mundo, sus servicios de parto están centrados en la paciente para evitar cualquier tipo de complicación. Cuentan con una de las mejores Unidades de Cuidados Intensivos Neonatales de Nivel III del mundo. \n\nLugares cercanos al hospital\nUn hospital con una excelente ubicación y diversos lugares cercanos a tu alcance. Dispondrás de restaurantes cercanos como Starbucks, Homestyle Hawaiian y California burritos, entre otros. Para pasar un rato agradable, tendrás un centro de recreación, estadio y un parque . \n\n\n\n\n','00:30:00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'SD_MARY_01.jpg','SD_MARY_02.jpg','SD_MARY_03.jpg'),
	(8,4,1,'Sharp Grossmont','sharp-grossmont-hospital.jpg','Es el centro de atención médica más grande de East County San Diego. Una de las razones para tener a tu bebé aquí es porque cuentan con una gran atención médica innovadora; al grado de tener las salas de emergencia más tecnológicas del país para que el paciente esté cómodo y tenga los mejores resultados. Estarás en un centro que ha tenido reconocimiento nacional por Brindar cuidado médico de excelencia para mujeres embarazadas y partos.\n\nLugares cercanos al hospital\nSharp Grossmont Hospital, de los hospitales con una ubicación destacada en donde encontraras más de 5 restaurantes para poder consumir deliciosos alimentos, además tendrás spas, centro de yoga y otros lugares por si quieres pasar un rato de tranquilidad o bien tendrás cerca un parque para poder pasar un rato en familia una vez que tu bebé haya llegado al mundo.\n\nUna hermosa experiencia \n\n','00:30:00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'CA_GROSSMONT_03.jpg','CA_GROSSMONT_01.jpg','CA_GROSSMONT_02.jpg'),
	(9,5,2,'Del Sol Medical Center','del-sol-medical-center.jpg','Altamente experimentado y capacitado para brindar el mejor servicio médico para  la mujer, parto y cuidados intensivos neonatales. Cuenta con personal multidisciplinario listo  para atender todas las necesidades maternales, además sus instalaciones son ideales para darle la bienvenida a tu recién nacido.\n\nCerca del Hospital podrás encontrar diferentes restaurantes de comida rápida, cafeterías tradicionales y una amplia gama de centros comerciales y\nsupermercados, para que no tengas que preocuparte por la movilidad, todo esta super cerca. \nAdemás tendrás lugares turísticos cercanos, como galerías de arte y el museo (Nombre del Museo) que narra la historia de la frontera entre Estados Unidos y México. El Paso es una ciudad llena de tranquilidad donde podrás disfrutar con tu bebé tendrás cerca el parque Travis White Park. \n\n','00:30:00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'PT_SOL_01.jpg','PT_SOL_02.jpg','PT_SOL_03.jpg'),
	(10,5,2,'Las Palmas Medical Center','las-palmas-medical-center.jpg','Reconocido por su excelencia en atención ginecológica, es el proveedor de salud médica líder en el paso de Texas. Cuenta con servicios específicamente para la mujer, además de viveros para cuidados intensivos de última generación. Durante su estancia mamá y bebé podrán tener acceso a espacios especialmente dedicados para su cuidado y comodidad.\n\nLugares cercanos al hospital \nCerca del Hospital podrás encontrar diferentes restaurantes de comida rápida, cafeterías tradicionales, además de una amplia gama de centros comerciales y\nsupermercados, para que no tengas que preocuparte por la movilidad,todo esta super cerca. \n\nAdemás tendrás lugares turísticos cercanos, como galerías de arte y el museo Chamizal National Memorial que narra la historia de la frontera entre Estados Unidos y México. El Paso es una ciudad llena de tranquilidad donde podrás disfrutar con tu bebé de paseos por el parque Travis White Park. \n\n','00:30:00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'PT_LASPALMAS_03.jpg','PT_LASPALMAS_01.jpg','PT_LASPALMAS_02.jpg'),
	(11,5,6,'brenda','','','00:00:00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'','',''),
	(12,5,4,'Mc Allen Medical Center','mc-allen-medical-center.jpg','Es reconocido por la Asociación The Leapfrog por ser un hospital con alta calidad en la atención y seguridad médica de sus pacientes. Ofrece atención avanzada en maternidad e incluye un área de cuidados intensivos neonatales, su sala de parto ha ganado reconocimientos  por reducir la inducción de parto y cesárea antes de las 39 semanas. Uno de los hospitales favoritos de nuestros pacientes y destacado por  su excelente  atención y agilidad en sus trámites.\n\nMuy cerca del hospital podrás encontrar diversos restaurantes, entre ellos Pocho’s que ofrece comida mexicana, algunos otros de comida italiana, marisquerías y restaurantes de comida rápida(Buffalo Wild Wings, Burger King), además de  buffets.\nLa ciudad es tan amigable que cuenta con parques como el de westside Park and Field para dar un paseo con tu bebé.\n\n','00:00:00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'MT_MCALLEN_02.jpg','MT_MCALLEN_01.jpg','MT_MCALLEN_03.jpg'),
	(13,5,4,'Río Grande Regional Hospital','rio-grande-regional-hospital.jpg','Es reconocido por su excelencia médica en cuidado materno, cuenta con su propio departamento de servicios de la mujer en donde se pueden encontrar una gran gama de servicios para embarazo, además alberga un gran equipo de personal altamente experimentado para atender a mamá y bebé de manera cálida, es un hospital reconocido por estar empeñado en cuidar de la salud familiar.\n\nEn los  alrededores del hospital podrás encontrar restaurantes con diversos estilos culinarios, entre ellos Pocho’s que ofrece comida mexicana, algunos otros de comida italiana y marisquerías, además de restaurantes de comida rápida(Buffalo Wild Wings, Burger King) y buffets.\nLa ciudad es tan amigable que cuenta con parques como el de westside Park and Field para dar un paseo con tu bebé.\n\n','00:00:00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'MT_RIOGRANDE_03.jpg','MT_RIOGRANDE_01.jpg','MT_RIOGRANDE_02.jpg'),
	(14,5,3,'Children’s Hospital Pavilion for Women','Pavilion.jpg','Es una de las instalaciones más importantes de Estados Unidos enfocada a la salud materno fetal y recién nacidos. Está caracterizado por ser un centro de excelencia especializado en la mujer. Sus instalaciones están equipadas con toda la tecnología y personal altamente especializado para brindarles a las madres sus  bebés la mejor atención en cualquier situación. \n\n\n\nLugares cercanos al hospital\nTendrás a tu alcance diversos restaurantes para ir a comer algo delicioso como Olive Garden Italian Restaurant, Luby’s, Raising Cane\'s, Chicken Fingers, Chacho\'s Mexican Restaurant y entre otros más de comida rápida.\nAdemás tendrás cerca el Museo de Bellas Artes de Houston, el zoológico de Houston, el teatro IMAX, el mariposario y el museo de Ciencias Naturales de Houston en donde se  exhiben una sala de dinosaurios y un planetario espectacular. \n\nVive esta experiencia de la mano de tu bebé \n\n','00:00:00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'CH_PAVILION_01.jpg','CH_PAVILION_03.jpg','CH_PAVILION_02.jpg'),
	(15,5,5,'Valley Baptist Medical Center','Baptist.jpg','Valley Baptist Medical Center\nUn hospital con excelente reputación, infraestructura y ubicación privilegiada. El hospital está listo para otorgar un nivel de atención digno para para el nacimiento de tu bebé, ya que cada día se están desarrollando procesos de mejora continua en la atención para mejorar la experiencia en la atención de mamá y bebé. \n\nLugares cercanos al hospital\nDe los hospitales favoritos de nuestros pacientes por su cercanía y comodidad a restaurantes, farmacias, centros, etc. Tendrás más de 10 restaurantes para comer algo rico e incluso restaurantes de comida Mexicana por si extrañas tu país, además de varios lugares para hospedarte durante tu visita a la bella ciudad de Brownsville. Podrás encontrar bancos cercanos y lugares para un rato de ocio junto con tu familia.  \n\n','00:00:00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'SH_BAPTIST_03.jpg','SH_BAPTIST_01.jpg','SH_BAPTIST_02.jpg');

/*!40000 ALTER TABLE `hospital` ENABLE KEYS */;
UNLOCK TABLES;


# Volcado de tabla hospital_availability
# ------------------------------------------------------------

DROP TABLE IF EXISTS `hospital_availability`;

CREATE TABLE `hospital_availability` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `hospital_id` int(10) unsigned NOT NULL,
  `day` enum('mon','tue','wed','thu','fri','sat','sun') COLLATE utf8mb4_unicode_ci NOT NULL,
  `time_start` time NOT NULL,
  `time_end` time NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `hospital_availability_hospital_id_foreign` (`hospital_id`),
  CONSTRAINT `hospital_availability_hospital_id_foreign` FOREIGN KEY (`hospital_id`) REFERENCES `hospital` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `hospital_availability` WRITE;
/*!40000 ALTER TABLE `hospital_availability` DISABLE KEYS */;

INSERT INTO `hospital_availability` (`id`, `hospital_id`, `day`, `time_start`, `time_end`, `created_at`, `updated_at`)
VALUES
	(1,5,'mon','09:00:00','17:00:00',NULL,NULL),
	(2,5,'tue','09:00:00','17:00:00',NULL,NULL),
	(3,5,'wed','09:00:00','17:00:00',NULL,NULL),
	(4,5,'thu','09:00:00','17:00:00',NULL,NULL),
	(5,5,'fri','09:00:00','17:00:00',NULL,NULL),
	(6,6,'mon','09:00:00','17:00:00',NULL,NULL),
	(7,6,'tue','09:00:00','17:00:00',NULL,NULL),
	(8,6,'wed','09:00:00','17:00:00',NULL,NULL),
	(9,6,'thu','09:00:00','17:00:00',NULL,NULL),
	(10,6,'fri','09:00:00','17:00:00',NULL,NULL),
	(11,7,'mon','09:00:00','17:00:00',NULL,NULL),
	(12,7,'tue','09:00:00','17:00:00',NULL,NULL),
	(13,7,'wed','09:00:00','17:00:00',NULL,NULL),
	(14,7,'thu','09:00:00','17:00:00',NULL,NULL),
	(15,7,'fri','09:00:00','17:00:00',NULL,NULL),
	(16,8,'mon','09:00:00','17:00:00',NULL,NULL),
	(17,8,'tue','09:00:00','17:00:00',NULL,NULL),
	(18,8,'wed','09:00:00','17:00:00',NULL,NULL),
	(19,8,'thu','09:00:00','17:00:00',NULL,NULL),
	(20,8,'fri','09:00:00','17:00:00',NULL,NULL),
	(21,9,'mon','09:00:00','17:00:00',NULL,NULL),
	(22,9,'tue','09:00:00','17:00:00',NULL,NULL),
	(23,9,'wed','09:00:00','17:00:00',NULL,NULL),
	(24,9,'thu','09:00:00','17:00:00',NULL,NULL),
	(25,9,'fri','09:00:00','17:00:00',NULL,NULL),
	(26,10,'mon','09:00:00','17:00:00',NULL,NULL),
	(27,10,'tue','09:00:00','17:00:00',NULL,NULL),
	(28,10,'wed','09:00:00','17:00:00',NULL,NULL),
	(29,10,'thu','09:00:00','17:00:00',NULL,NULL),
	(30,10,'fri','09:00:00','17:00:00',NULL,NULL);

/*!40000 ALTER TABLE `hospital_availability` ENABLE KEYS */;
UNLOCK TABLES;


# Volcado de tabla hospital_contact
# ------------------------------------------------------------

DROP TABLE IF EXISTS `hospital_contact`;

CREATE TABLE `hospital_contact` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `hospital_id` int(10) unsigned NOT NULL,
  `contact` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('home_phone','cell_phone','office_phone','email','web') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `hospital_contact_hospital_id_foreign` (`hospital_id`),
  CONSTRAINT `hospital_contact_hospital_id_foreign` FOREIGN KEY (`hospital_id`) REFERENCES `hospital` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Volcado de tabla hospital_product
# ------------------------------------------------------------

DROP TABLE IF EXISTS `hospital_product`;

CREATE TABLE `hospital_product` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `hospital_id` int(10) unsigned NOT NULL,
  `product_id` int(10) unsigned NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `deposit` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `hospital_id` (`hospital_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `hospital_product_ibfk_1` FOREIGN KEY (`hospital_id`) REFERENCES `hospital` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `hospital_product_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `hospital_product` WRITE;
/*!40000 ALTER TABLE `hospital_product` DISABLE KEYS */;

INSERT INTO `hospital_product` (`id`, `hospital_id`, `product_id`, `price`, `deposit`, `created_at`, `updated_at`)
VALUES
	(1,5,1,13500.00,10.00,'2020-03-05 10:28:43',NULL),
	(2,5,2,15500.00,10.00,'2020-03-05 10:28:54',NULL),
	(5,6,1,13500.00,10.00,'2020-03-05 10:29:26',NULL),
	(6,6,2,15500.00,10.00,'2020-03-05 10:29:31',NULL),
	(7,7,1,13500.00,10.00,'2020-03-05 10:30:19',NULL),
	(8,7,2,15500.00,10.00,'2020-03-05 10:30:25',NULL),
	(9,8,1,13500.00,10.00,'2020-03-05 10:31:21',NULL),
	(10,8,2,15500.00,10.00,'2020-03-05 10:31:26',NULL),
	(11,9,1,6500.00,10.00,'2020-03-05 10:32:17',NULL),
	(12,9,2,7500.00,10.00,'2020-03-05 10:32:21',NULL),
	(13,10,1,7985.00,10.00,'2020-03-05 10:33:18',NULL),
	(14,10,2,9443.00,10.00,'2020-03-05 10:33:38',NULL),
	(15,11,1,12940.00,10.00,'2019-04-10 17:18:19',NULL),
	(16,11,2,13370.00,10.00,'2019-04-10 17:18:21',NULL),
	(17,12,1,13500.00,10.00,'2020-03-05 10:36:57',NULL),
	(18,12,2,17500.00,10.00,'2020-03-05 10:37:02',NULL),
	(19,13,1,10300.00,10.00,'2020-03-05 10:38:03',NULL),
	(20,13,2,14600.00,10.00,'2020-03-05 10:38:11',NULL),
	(21,14,1,15300.00,10.00,'2020-03-05 10:40:12',NULL),
	(22,14,2,16300.00,10.00,'2020-03-05 10:40:12',NULL),
	(23,15,1,10300.00,10.00,'2020-03-05 10:43:40',NULL),
	(24,15,2,14600.00,10.00,'2020-03-05 10:44:02',NULL);

/*!40000 ALTER TABLE `hospital_product` ENABLE KEYS */;
UNLOCK TABLES;


# Volcado de tabla hospital_profile
# ------------------------------------------------------------

DROP TABLE IF EXISTS `hospital_profile`;

CREATE TABLE `hospital_profile` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `hospital_id` int(10) unsigned NOT NULL,
  `detail` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('speciality','experience') COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `hospital_profile_hospital_id_foreign` (`hospital_id`),
  CONSTRAINT `hospital_profile_hospital_id_foreign` FOREIGN KEY (`hospital_id`) REFERENCES `hospital` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `hospital_profile` WRITE;
/*!40000 ALTER TABLE `hospital_profile` DISABLE KEYS */;

INSERT INTO `hospital_profile` (`id`, `hospital_id`, `detail`, `type`)
VALUES
	(2,5,'Maternidad Internacional','speciality'),
	(4,5,'50 partos mensuales de mamás latinoamericanas','experience'),
	(5,5,'15 años de experiencia','experience'),
	(6,6,'Maternidad Internacional','speciality'),
	(7,6,'Pediatría','speciality'),
	(8,6,'100 partos mensuales de mamás latinoamericanas','experience'),
	(9,6,'10 años de experiencia','experience'),
	(10,7,'Ginecología','speciality'),
	(11,7,'Obstetricia','speciality'),
	(12,7,'25 años de experiencia','experience'),
	(13,7,'200 partos mensuales de mamás latinoamericanas','experience'),
	(14,8,'Ginecología','speciality'),
	(15,8,'Obstetricia','speciality'),
	(16,8,'15 años de experiencia','experience'),
	(17,8,'70 partos mensuales de mamás latinoamericanas','experience'),
	(18,8,'Maternidad internacional','speciality'),
	(19,9,'25 años experiencia','experience'),
	(20,9,'Ginecología','speciality'),
	(21,9,'Obstetricia','speciality'),
	(22,9,'100 partos mensuales de mamás latinoamericanas','experience'),
	(23,10,'Obstetricia','speciality'),
	(24,10,'Ginecología','speciality'),
	(31,10,'5 años de experiencia','experience');

/*!40000 ALTER TABLE `hospital_profile` ENABLE KEYS */;
UNLOCK TABLES;


# Volcado de tabla hospital_schedule
# ------------------------------------------------------------

DROP TABLE IF EXISTS `hospital_schedule`;

CREATE TABLE `hospital_schedule` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `hospital_id` int(10) unsigned NOT NULL,
  `pacient_id` int(10) unsigned NOT NULL,
  `cart_id` int(10) unsigned NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `hospital_schedule_hospital_id_foreign` (`hospital_id`),
  KEY `hospital_schedule_pacient_id_foreign` (`pacient_id`),
  KEY `cart_id` (`cart_id`),
  CONSTRAINT `hospital_schedule_hospital_id_foreign` FOREIGN KEY (`hospital_id`) REFERENCES `hospital` (`id`) ON DELETE CASCADE,
  CONSTRAINT `hospital_schedule_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `hospital_schedule_pacient_id_foreign` FOREIGN KEY (`pacient_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Volcado de tabla log
# ------------------------------------------------------------

DROP TABLE IF EXISTS `log`;

CREATE TABLE `log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('server','database') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'server',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `log_user_id_foreign` (`user_id`),
  CONSTRAINT `log_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `log` WRITE;
/*!40000 ALTER TABLE `log` DISABLE KEYS */;

INSERT INTO `log` (`id`, `uuid`, `user_id`, `code`, `description`, `type`, `created_at`, `updated_at`)
VALUES
	(45,'5c633b58dc16e',42,'23000','SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry \'42\' for key \'PRIMARY\' (SQL: insert into `mom_profile` (`phone`, `birth_date`, `job`, `pregnancy_week`, `how_found`, `about_me`, `user_id`, `updated_at`, `created_at`) values (23232323, 1994-02-10, Ocupación, 21, sdlfasdlfsdfadsfads, asfadsfljkladsflasfv,msd vk, 42, 2019-02-12 15:32:08, 2019-02-12 15:32:08))','database','2019-02-12 15:32:08','2019-02-12 15:32:08'),
	(46,'5c6f250e01660',42,'42S22','SQLSTATE[42S22]: Column not found: 1054 Unknown column \'updated_at\' in \'field list\' (SQL: insert into `cart_item` (`hospital_product_id`, `quantity`, `total`, `cart_id`, `updated_at`, `created_at`) values (23, 1, 16500.00, 1, 2019-02-21 16:24:13, 2019-02-21 16:24:13))','database','2019-02-21 16:24:14','2019-02-21 16:24:14'),
	(47,'5c7065c51f8e1',42,'23000','SQLSTATE[23000]: Integrity constraint violation: 1452 Cannot add or update a child row: a foreign key constraint fails (`babypassport`.`hospital_schedule`, CONSTRAINT `hospital_schedule_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`id`) ON UPDATE CASCADE) (SQL: insert into `hospital_schedule` (`pacient_id`, `start_date`, `end_date`, `hospital_id`) values (42, 2019-02-21 11:00:00, 2019-02-21 11:30:00, 5))','database','2019-02-22 15:12:37','2019-02-22 15:12:37'),
	(48,'5c75a740ef554',43,'23000','SQLSTATE[23000]: Integrity constraint violation: 1048 Column \'cart_id\' cannot be null (SQL: insert into `hospital_schedule` (`pacient_id`, `cart_id`, `start_date`, `end_date`, `hospital_id`) values (43, , 2019-02-27 09:30:00, 2019-02-27 10:00:00, 9))','database','2019-02-26 14:53:20','2019-02-26 14:53:20'),
	(49,'5c95152dc35eb',63,'42S22','SQLSTATE[42S22]: Column not found: 1054 Unknown column \'voucher\' in \'field list\' (SQL: update `cart` set `updated_at` = 2019-03-22 11:02:37, `voucher` = 1553274157.jpg where `id` = 32)','database','2019-03-22 11:02:37','2019-03-22 11:02:37'),
	(50,'5c95153e278bf',63,'42S22','SQLSTATE[42S22]: Column not found: 1054 Unknown column \'voucher\' in \'field list\' (SQL: update `cart` set `updated_at` = 2019-03-22 11:02:54, `voucher` = 1553274174.jpg where `id` = 32)','database','2019-03-22 11:02:54','2019-03-22 11:02:54'),
	(51,'5c9515c3a3d04',63,'42S22','SQLSTATE[42S22]: Column not found: 1054 Unknown column \'voucher\' in \'field list\' (SQL: update `cart` set `updated_at` = 2019-03-22 11:05:07, `voucher` = 1553274307.jpg where `id` = 32)','database','2019-03-22 11:05:07','2019-03-22 11:05:07'),
	(52,'5e13a44fbecff',NULL,'530','Expected response code 250 but got code \"530\", with message \"530 5.7.1 Authentication required\r\n\"','server','2020-01-06 15:19:11','2020-01-06 15:19:11');

/*!40000 ALTER TABLE `log` ENABLE KEYS */;
UNLOCK TABLES;


# Volcado de tabla migrations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;

INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES
	(1,'2014_10_12_000000_create_users_table',1),
	(2,'2014_10_12_100000_create_password_resets_table',1),
	(3,'2019_01_17_182808_create_log_table',1),
	(5,'2019_01_22_130757_create_user_addresses_table',2),
	(6,'2019_01_30_123315_create_mom_profile',3),
	(8,'2019_01_30_123339_create_mom_history',4),
	(11,'2019_02_01_095041_create_tag',5),
	(12,'2019_02_01_095505_create_category',5),
	(13,'2019_02_01_095733_create_blog',6),
	(14,'2019_02_01_100741_create_blog_tag',7),
	(15,'2019_02_01_101039_create_blog_category',7),
	(57,'2019_02_05_125950_create_rating',8),
	(58,'2019_02_05_125951_create_hospital',8),
	(59,'2019_02_05_125952_create_hospital_availability',8),
	(60,'2019_02_05_125953_create_hospital_schedule',8),
	(61,'2019_02_05_125954_create_hospital_contact',8),
	(62,'2019_02_05_125955_create_hospital_profile',8),
	(63,'2019_02_05_135950_create_doctor_profile',8),
	(64,'2019_02_05_141407_create_doctor_profile_detail',8),
	(65,'2019_02_05_141614_create_doctor_contact',8),
	(66,'2019_02_05_143654_create_doctor_schedule',8),
	(67,'2019_02_05_143828_create_doctor_availability',8),
	(68,'2019_02_01_095040_create_product',9),
	(69,'2019_02_01_095734_create_blog_topic',9),
	(70,'2019_02_10_142740_product',9),
	(71,'2019_02_05_125949_create_city',10),
	(72,'2019_02_01_095041_create_product_detail',10),
	(73,'2019_02_01_095042_create_tag',10),
	(74,'2019_02_05_125949_create_rating',10),
	(75,'2019_02_05_125956_create_hospital_product',10),
	(76,'2019_02_20_140428_create_cart',11),
	(77,'2019_02_20_150225_create_cart_item',11),
	(78,'2019_02_05_125956_create_hospital_schedule',11),
	(79,'2019_02_05_125957_create_hospital_contact',12),
	(80,'2019_02_05_125958_create_hospital_profile',12),
	(81,'2019_02_05_125959_create_hospital_product',12),
	(82,'2019_02_05_125960_create_cart',12),
	(83,'2019_02_05_125961_create_cart_item',12),
	(85,'2019_03_13_150536_create_notification_table',13),
	(87,'2019_04_02_122130_create_cart_payment_table',14),
	(90,'2019_04_04_163054_create_user_tracking_table',15),
	(92,'2019_06_18_105729_create_advertising_table',16);

/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;


# Volcado de tabla mom_history
# ------------------------------------------------------------

DROP TABLE IF EXISTS `mom_history`;

CREATE TABLE `mom_history` (
  `user_id` int(10) unsigned NOT NULL,
  `father_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `father_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `father_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `family_from` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `family_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `married` tinyint(1) NOT NULL DEFAULT '0',
  `marriage_paper` tinyint(1) NOT NULL DEFAULT '0',
  `usa_family` tinyint(1) NOT NULL DEFAULT '0',
  `usa_zip` tinyint(1) NOT NULL DEFAULT '0',
  `first_baby` tinyint(1) NOT NULL DEFAULT '0',
  `alone_ride` tinyint(1) NOT NULL DEFAULT '0',
  `usa_child` tinyint(1) NOT NULL DEFAULT '0',
  `familiar_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `familiar_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  CONSTRAINT `mom_history_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Volcado de tabla mom_profile
# ------------------------------------------------------------

DROP TABLE IF EXISTS `mom_profile`;

CREATE TABLE `mom_profile` (
  `user_id` int(10) unsigned NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `job` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pregnancy_week` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `how_found` text COLLATE utf8mb4_unicode_ci,
  `about_me` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  CONSTRAINT `mom_profile_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `mom_profile` WRITE;
/*!40000 ALTER TABLE `mom_profile` DISABLE KEYS */;

INSERT INTO `mom_profile` (`user_id`, `phone`, `birth_date`, `job`, `pregnancy_week`, `how_found`, `about_me`, `created_at`, `updated_at`)
VALUES
	(42,'4271822987','1991-08-17','NINI','23','0',NULL,'2019-07-01 11:10:35','2019-10-07 16:32:42');

/*!40000 ALTER TABLE `mom_profile` ENABLE KEYS */;
UNLOCK TABLES;


# Volcado de tabla notification
# ------------------------------------------------------------

DROP TABLE IF EXISTS `notification`;

CREATE TABLE `notification` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `receiver` enum('pacient','superadmin','main_doctor') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'superadmin',
  `read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notification_user_id_foreign` (`user_id`),
  CONSTRAINT `notification_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Volcado de tabla password_resets
# ------------------------------------------------------------

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Volcado de tabla product
# ------------------------------------------------------------

DROP TABLE IF EXISTS `product`;

CREATE TABLE `product` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) unsigned DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_product_unique` (`product`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `product` WRITE;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;

INSERT INTO `product` (`id`, `product`, `description`, `status`, `created_at`, `updated_at`)
VALUES
	(1,'PARTO NATURAL','',1,NULL,NULL),
	(2,'PARTO CESAREA','',1,NULL,'2019-10-07 16:36:51'),
	(3,'PARTO GEMELAR NATURAL','',0,NULL,NULL),
	(4,'PARTO GEMELAR CESAREA','',0,NULL,NULL),
	(5,'Producto prueba','',1,NULL,NULL);

/*!40000 ALTER TABLE `product` ENABLE KEYS */;
UNLOCK TABLES;


# Volcado de tabla product_detail
# ------------------------------------------------------------

DROP TABLE IF EXISTS `product_detail`;

CREATE TABLE `product_detail` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `detail` varchar(255) NOT NULL DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `product_detail` WRITE;
/*!40000 ALTER TABLE `product_detail` DISABLE KEYS */;

INSERT INTO `product_detail` (`id`, `product_id`, `detail`, `created_at`, `updated_at`)
VALUES
	(1,1,'Asesoría Legal','2019-02-18 09:52:01',NULL),
	(2,1,'Cita de programación','2019-02-18 09:52:17',NULL),
	(4,1,'Honorarios del médico','2019-02-18 09:52:45',NULL),
	(5,1,'Honorarios del pediátrico','2019-02-18 09:52:59',NULL),
	(6,1,'Honorarios del anestesiólogo','2019-02-18 09:53:15',NULL),
	(7,1,'Estancia post parto (24 horas hasta 76 horas)','2020-03-05 11:04:03',NULL),
	(8,1,'Código postal en USA','2019-02-18 09:53:46',NULL),
	(9,1,'Hospital','2019-02-18 09:53:52',NULL),
	(10,2,'Asesoría Legal','2019-10-07 16:36:51','2019-10-07 16:36:51'),
	(11,2,'Cita de programación','2019-10-07 16:36:51','2019-10-07 16:36:51'),
	(13,2,'Honorarios del médico','2019-10-07 16:36:51','2019-10-07 16:36:51'),
	(14,2,'Honorarios del pediátrico','2019-10-07 16:36:51','2019-10-07 16:36:51'),
	(15,2,'Honorarios del anestesiólogo','2019-10-07 16:36:51','2019-10-07 16:36:51'),
	(16,2,'Estancia post parto (24 horas hasta 76 horas)','2020-03-05 11:10:31','2019-10-07 16:36:51'),
	(17,2,'Código postal en USA','2019-10-07 16:36:51','2019-10-07 16:36:51'),
	(18,2,'Hospital','2019-10-07 16:36:51','2019-10-07 16:36:51'),
	(19,3,'Asesoría Legal','2019-02-18 09:52:01',NULL),
	(20,3,'Cita de programación','2019-02-18 09:52:17',NULL),
	(21,3,'Tour de Hospital','2019-02-18 09:52:31',NULL),
	(22,3,'Honorarios del médico','2019-02-18 09:52:45',NULL),
	(23,3,'Honorarios del pediátrico','2019-02-18 09:52:59',NULL),
	(24,3,'Honorarios del anestesiólogo','2019-02-18 09:53:15',NULL),
	(25,3,'Estancia post parto (36 horas)','2019-02-18 09:53:33',NULL),
	(26,3,'Código postal en USA','2019-02-18 09:53:46',NULL),
	(27,3,'Hospital','2019-02-18 09:53:52',NULL),
	(28,4,'Asesoría Legal','2019-02-18 09:52:01',NULL),
	(29,4,'Cita de programación','2019-02-18 09:52:17',NULL),
	(30,4,'Tour de Hospital','2019-02-18 09:52:31',NULL),
	(31,4,'Honorarios del médico','2019-02-18 09:52:45',NULL),
	(32,4,'Honorarios del pediátrico','2019-02-18 09:52:59',NULL),
	(33,4,'Honorarios del anestesiólogo','2019-02-18 09:53:15',NULL),
	(34,4,'Estancia post parto (36 horas)','2019-02-18 09:53:33',NULL),
	(35,4,'Código postal en USA','2019-02-18 09:53:46',NULL),
	(36,4,'Hospital','2019-02-18 09:53:52',NULL),
	(37,5,'1','2019-03-07 13:01:44','2019-03-07 13:01:44'),
	(38,5,'2','2019-03-07 13:01:44','2019-03-07 13:01:44'),
	(39,6,'1','2019-03-07 14:09:36','2019-03-07 14:09:36'),
	(41,6,'3','2019-03-07 14:09:36','2019-03-07 14:09:36'),
	(42,1,'2 revisiones medicas','2020-03-05 11:05:27',NULL),
	(43,1,'Acta de nacimiento','2020-03-05 11:09:34',NULL),
	(44,1,'Seguro social ','2020-03-05 11:09:38',NULL),
	(45,2,'2 revisiones medicas','2020-03-05 11:10:41',NULL),
	(46,2,'Acta de nacimiento','2020-03-05 11:11:07',NULL),
	(47,2,'Seguro social ','2020-03-05 11:11:16',NULL);

/*!40000 ALTER TABLE `product_detail` ENABLE KEYS */;
UNLOCK TABLES;


# Volcado de tabla rating
# ------------------------------------------------------------

DROP TABLE IF EXISTS `rating`;

CREATE TABLE `rating` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `star_number` tinyint(4) NOT NULL,
  `rating_description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) unsigned DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `rating` WRITE;
/*!40000 ALTER TABLE `rating` DISABLE KEYS */;

INSERT INTO `rating` (`id`, `star_number`, `rating_description`, `status`, `created_at`, `updated_at`)
VALUES
	(1,1,'Newbie',1,NULL,NULL),
	(2,2,'Basic',1,NULL,'2019-03-07 15:06:37'),
	(3,3,'Pro',1,NULL,NULL),
	(4,4,'Ultimate',1,NULL,NULL),
	(5,5,'Master',1,NULL,NULL),
	(6,2,'Sample',0,'2019-03-07 15:07:50','2019-03-07 15:08:07');

/*!40000 ALTER TABLE `rating` ENABLE KEYS */;
UNLOCK TABLES;


# Volcado de tabla tag
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tag`;

CREATE TABLE `tag` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tag` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tag` (`tag`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `tag` WRITE;
/*!40000 ALTER TABLE `tag` DISABLE KEYS */;

INSERT INTO `tag` (`id`, `tag`, `status`, `created_at`, `updated_at`)
VALUES
	(1,'embarazo',1,NULL,'2019-03-05 12:42:28'),
	(2,'planificación',1,NULL,NULL),
	(3,'mamá',1,NULL,NULL),
	(4,'relajación',1,NULL,'2019-03-05 11:40:48'),
	(5,'síntomas',1,NULL,NULL),
	(6,'evento',1,NULL,NULL),
	(7,'estudios',1,NULL,NULL),
	(8,'ejercicio',1,NULL,'2019-03-05 11:20:36'),
	(9,'entretenimiento',1,NULL,NULL),
	(10,'belleza',1,NULL,NULL),
	(11,'padres',1,NULL,NULL),
	(20,'turismo',1,'2019-03-08 10:58:44','2019-03-08 10:58:44'),
	(21,'parto',1,'2019-03-08 10:58:55','2019-03-08 10:58:55'),
	(22,'nacionalidad',1,'2019-03-08 10:59:00','2019-03-08 10:59:00');

/*!40000 ALTER TABLE `tag` ENABLE KEYS */;
UNLOCK TABLES;


# Volcado de tabla user_address
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_address`;

CREATE TABLE `user_address` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `zip_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitude` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_address_user_id_foreign` (`user_id`),
  CONSTRAINT `user_address_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Volcado de tabla user_tracking
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_tracking`;

CREATE TABLE `user_tracking` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Volcado de tabla users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('pacient','main_doctor','superadmin') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pacient',
  `step` enum('lead','profile','maternity_package','parcial_payment','appointment','preregister','tracing','done') COLLATE utf8mb4_unicode_ci DEFAULT 'lead',
  `status` enum('active','on_revision','inactive','active_subscription') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` text COLLATE utf8mb4_unicode_ci,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `name`, `photo`, `email`, `type`, `step`, `status`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`)
VALUES
	(42,'Areli Martinez Boveda','1552337394.png','areli@test.com','pacient','maternity_package','active',NULL,'$2y$10$RUIFykzJgOH1Z/.XA.kGieVig0rfqf.3TKLd.rM5SEBmoDEwhJA9m','zpOUDI2WDCarp9knjDjkoTtZEd2IMu9VKNjg8GATbINfMdQb1D5NV8z03FtR','2019-02-12 11:14:17','2019-07-02 10:52:14'),
	(43,'Melissa Aleman',NULL,'melissa@test.com','pacient','profile','active',NULL,'$2y$10$9t.gwISRFMcWxBqBUqQEZevgzJOlQ2l6U4QG33W7ZHCivInS8BJ6m','7vOn6PoLHHzmQZiuPK44HucYqIn3FAXgp5ZDvpixVHfF26hETadjK7JPI6dp','2019-02-15 16:03:36','2019-06-27 14:12:27'),
	(44,'Test',NULL,'test100@test.com','pacient','lead','active',NULL,'$2y$10$YjeAYfhOPmiwcGICzqo7VeKmwM9Lz.axzPaelsTRbXgh2O9HQt9oC','BNHf9DGnZ9I0oXPRh0HQrwpHQNzpmvnrPZqtSBfEi12gual5TDuu14nKUfD3','2019-02-15 16:13:03','2019-02-15 16:13:03'),
	(45,'Test',NULL,'test102@test.com','pacient','lead','active',NULL,'$2y$10$fBAOF0Nai96UFRCgJCVpCORi2dQC2hwtfZrdQyrMMj02bKEZeXV.i','3epHIJQKg6tNcx9RPYm0FRrukX2wvl9xbEPs3NWKh1cRydT7z9zTCvr8BJna','2019-02-15 16:14:39','2019-02-15 16:14:39'),
	(46,'Test',NULL,'test110@test.com','pacient','lead','active',NULL,'$2y$10$rEsaIRdwHUaCBCtgWKTldutakXNnTMb/LzMEjdyw/UJuVjSZrFTxS','nEhF7JBioMKqWVyQ8thMLFDpwyEnmHTHFTwDIT1eh178UDIefrT25XnsmrU4','2019-02-15 16:24:57','2019-02-15 16:24:57'),
	(48,'Laura Gutierrez',NULL,'laura@test.com','pacient','lead','active',NULL,'$2y$10$7foGcgDIopGUGGxJopQ.x.unT.KTyxf0wEWarYeRRDhLFHUGRzK4m',NULL,'2019-02-27 10:14:31','2019-02-27 10:14:31'),
	(49,'Ana',NULL,'ana@test.com','pacient','lead','active',NULL,'$2y$10$eMmFYUA0ztlOdJYeCYYu2uiJYd55axRuzgGvXaVppHhTOaSGr8Ynq','F5ZYkt2qppWKqR7nvmTRJCd8SOW6duh434kMt3oU9aUxmlSH0gKCdCzo2m3q','2019-02-27 10:17:05','2019-02-27 10:17:05'),
	(50,'Jaqueline',NULL,'jaqueline@test.com','pacient','lead','active',NULL,'$2y$10$IaT7xMElCMF9HHHQuZK5pOvh5PL46TT2Y5/E9DCW0NHAjkE8K3.rG',NULL,'2019-02-27 10:21:00','2019-02-27 10:21:00'),
	(51,'Ahri','1551300129.png','ahri@test.com','pacient','lead','active',NULL,'$2y$10$E1XoBdwYk9vROJPn3s3ngeSE3DNpJMtUTYIveGu414hY8o8IvVegG','WIXtxdn8tU6t7nI03kLvHVtggXNYxsHgP0azmcQcMResu5NWmxXuAz1yqBxQ','2019-02-27 10:24:24','2019-02-27 14:42:09'),
	(52,'Annie',NULL,'annie@test.com','pacient','lead','active',NULL,'$2y$10$hceHUYkROgpYSTwiYKCzeuGz9Pe/Aysqb3mFGgo/NPqSAEXAd0JP.','wirQcLX2yWkDkaNB7XBpIbs8qSwT8qD29YWQd5JmDgz5oGV5jYJvCuP5hFRP','2019-02-27 10:31:09','2019-02-27 10:31:09'),
	(53,'Lissandra',NULL,'lissandra@test.com','pacient','lead','active',NULL,'$2y$10$ly8NAVBNW.yhiw76Wu2OEO1qogOK7dPgg0Zk1dSu1h6zIvli/ZYpa','51Q7dH8560BvJQuHa5DcgPKelacUdJmqHo0Sg7TLuogVeVUjaIAEWuD6h2Ay','2019-02-27 10:38:11','2019-02-27 10:38:11'),
	(54,'Camille',NULL,'camille@test.com','pacient','lead','active',NULL,'$2y$10$9VbpT9mzG2GphPcMZAqWl.5Q46WfwxYongS0ZkErGLVr7HvtdmwHi','YSfGQvaYsiVQZDxmHyAMuoy7s1hJ0LBfJDqhq1Ke0NtP6PUjoTq5peDAWPF1','2019-02-27 10:39:14','2019-02-27 10:39:14'),
	(55,'Jinx',NULL,'jinx@test.com','pacient','lead','active',NULL,'$2y$10$49u7.prgxW5q9lpCVktygenjvzSHGCSfhyVfwbmrtQcWqPq2arPIC','MNd8U1BBzCfFOOBvSztR6WMMEkgSniSmLowP8FWSgus1b7kykMOHtiSKLngw','2019-02-27 10:41:43','2019-02-27 10:41:43'),
	(56,'Xayah',NULL,'xayah@test.com','pacient','lead','active',NULL,'$2y$10$hJzzWhhhW7dmtPeqAedJsugHQjpYeqyJ3qTRXhGe9fZC3VL4nVBBy','Ve8HF2ewMKikBEyZSMSCVqMz8rJtymcoL1gpQETeIN4Fuyul3s5Tyedh9o6R','2019-02-27 10:42:37','2019-02-27 10:42:37'),
	(57,'Agustina',NULL,'agustina@test.com','pacient','lead','active',NULL,'$2y$10$fnIyv3QW.YJAs8u/6rrwEOTuMQjtJOP7kQ.xVeyhgCuS9eDbyKwpS','P9ybpUBQavcgRoRFyK1LzT46NTO0j8r2kavAcMv5QT8bLjLqlN1UIcvogB1Q','2019-02-27 15:26:27','2019-02-27 15:26:27'),
	(58,'Administrador',NULL,'admin@test.com','superadmin','lead','active',NULL,'$2y$10$RUIFykzJgOH1Z/.XA.kGieVig0rfqf.3TKLd.rM5SEBmoDEwhJA9m','TLFuKotqjcPZeqzzpFvrXcNVhMtLzUDwkakW8Qc62fPZKFvZnMX9QJIVEIcj',NULL,NULL),
	(59,'Karla Rivera','1552326252.png','karlarivera@test.com','pacient','lead','active',NULL,'$2y$10$aiPezqwJ3WgmxDkHo/QzeO1YcFK3W8ElbLAVAqK0ZriX2rSKy8wvG','yyI03qiV09prAZZyZ4Hp4E8tUFr8eyo1uJ6hlsIcECPxOoQjqhfAjdEXPZVx','2019-03-11 11:43:53','2019-03-11 11:44:12'),
	(60,'Alondra',NULL,'alondra@test.com','pacient','lead','active',NULL,'$2y$10$R.VbuyS93R0kIZbJNHJIVOL.96sNqZU4GU/Hh2pscCuNdJP5iLXge',NULL,'2019-03-11 14:53:57','2019-03-11 14:53:57'),
	(61,'Carmen Morales',NULL,'carmen_morales@test.com','pacient','lead','active',NULL,'$2y$10$ttPigQxnUF.by2GDLlqAaOuoKWPdC3Dl3zuNImshPvKLcGfxvYkcq','dJenBPE72lADwXt7bbkwTGUiNcq7qlnqCpd0nKMFXMQHB6IYHWis8pcRga1b','2019-03-14 12:21:25','2019-03-14 12:21:25'),
	(62,'Jaqueline',NULL,'jaqueline2@test.com','pacient','lead','active',NULL,'$2y$10$WHgHhREAIhBFKntU9TfcoeQfHjc1N0Mq4Mp3eycOQA8CM889AlH6u','v79QWdNl9L3E1ovA3MYOgOeqaUpaaXkmN9usBShUxSj5Xhz0GSuRXIb9BQwP','2019-03-14 12:24:08','2019-03-14 12:24:08'),
	(63,'Carmen',NULL,'carmen@test.com','pacient','maternity_package','active',NULL,'$2y$10$VgsEehFk5PZNaKsIXeW.xepapXK/FBIxxpyvj6ycdnBKbo4JrquaK','NdMYxUmdn9Yao6MIRGgoXYkJJBNOpxyTASndMK6eq6d6ImJJRGj9RV1EUzK0','2019-03-22 09:23:13','2019-04-10 17:16:15'),
	(64,'Zoe',NULL,'zoe@test.com','pacient','lead','active',NULL,'$2y$10$VgsEehFk5PZNaKsIXeW.xepapXK/FBIxxpyvj6ycdnBKbo4JrquaK','85DGTkIho5Basr3vSPQx18YlKHmGHxSwYgrZQxrzxSZ1S5onsKbdIdxVxaoq','2019-03-22 12:14:12','2019-03-22 12:14:12'),
	(65,'Doctor Test',NULL,'doctor@test.com','main_doctor','lead','active_subscription',NULL,NULL,NULL,'2019-04-02 11:40:26','2019-04-02 11:40:26'),
	(66,'Test',NULL,'test12@test.com','pacient','maternity_package','active',NULL,'$2y$10$D7cEzqZLV829Ug0mymuiR.tsoHAg9UzRB3gA.cqjaMs2nGhFvwFoi','PROIpLd4GumSCYRwikyLoxuYuoXHqBzrDGiXZLkIGKCfIMsybdzr3OCJUjXC','2019-04-02 11:48:13','2019-04-02 11:48:13'),
	(67,'Admin',NULL,'test@admin.com','superadmin','lead','active',NULL,'$2y$10$JKNHHRRhAZQacmxaG/B3yutCPV4CPA6sJvrCfskq6tC.Euo9NtAGe','VdntDgvTsfgX58ES9S4BxCj3lGC8I9QjMZIO4LdSK1VARoHPeHvUki6Zo44b','2020-01-06 15:19:11','2020-01-06 15:19:11');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
