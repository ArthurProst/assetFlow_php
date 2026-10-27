<?php
declare(strict_types=1);

namespace App\Models;

use PDO;

class Asset extends BaseModel
{
    public function findAll(): array
    {
        $sql = "
            SELECT 
                a.id,
                a.code_inventaire,
                a.designation,
                a.type,
                a.statut,
                a.valeur_achat,
                a.date_achat,
                a.created_at,
                u.nom AS affecte_nom,
                u.prenom AS affecte_prenom,
                u.email AS affecte_email,
                asg.date_fin_prevue
            FROM assets a
            LEFT JOIN assignments asg ON a.id = asg.asset_id AND asg.date_restitution IS NULL
            LEFT JOIN users u ON asg.user_id = u.id
            ORDER BY a.id ASC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function findById(int $id): ?array
    {
        $sql = "
            SELECT 
                a.*,
                u.nom AS affecte_nom,
                u.prenom AS affecte_prenom,
                asg.date_debut AS affecte_date_debut,
                asg.date_fin_prevue AS affecte_date_fin_prevue
            FROM assets a
            LEFT JOIN assignments asg ON a.id = asg.asset_id AND asg.date_restitution IS NULL
            LEFT JOIN users u ON asg.user_id = u.id
            WHERE a.id = :id
            LIMIT 1
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $asset = $stmt->fetch();
        return $asset ?: null;
    }
}
