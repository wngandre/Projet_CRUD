## -- Structure de la table `clients`

CREATE TABLE `clients` (
`id` int NOT NULL,
`name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
`email` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
`phone` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
`address` varchar(200) COLLATE utf8mb4_general_ci DEFAULT NULL,
`created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

---

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
`id` int NOT NULL,
`username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
`email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
`password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
`created_at` datetime DEFAULT CURRENT_TIMESTAMP,
`updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
`admin` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
