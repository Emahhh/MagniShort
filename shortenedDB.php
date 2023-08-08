<?php

class ShortenedDB
{
    private $db;

    public function __construct()
    {
        $this->db = new SQLite3('shortener.sqlite');
        $this->createTableIfNotExists();
    }

    private function createTableIfNotExists()
    {
        $query = "CREATE TABLE IF NOT EXISTS shortened_urls (
            id INTEGER PRIMARY KEY,
            short_code TEXT NOT NULL,
            magnet_url TEXT NOT NULL
        )";
        $this->db->exec($query);
    }

    private function generateShortCode(): string
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $shortCode = '';
        for ($i = 0; $i < 6; $i++) {
            $shortCode .= $characters[rand(0, strlen($characters) - 1)];
        }

        // UNIQUE: check if short code already exists
        $query = "SELECT COUNT(*) FROM shortened_urls WHERE short_code = :short_code";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':short_code', $shortCode, SQLITE3_TEXT);
        $result = $stmt->execute();
        $row = $result->fetchArray();

        if ($row[0] > 0) {
            return $this->generateShortCode();
        }else {
            return $shortCode;
        }

    }

    public function shortenMagnetURL($magnetURL): string
    {
        $shortCode = $this->generateShortCode();
        $query = "INSERT INTO shortened_urls (short_code, magnet_url) VALUES (:short_code, :magnet_url)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':short_code', $shortCode, SQLITE3_TEXT);
        $stmt->bindValue(':magnet_url', $magnetURL, SQLITE3_TEXT);
        $stmt->execute();
        return $shortCode;
    }

    public function getMagnetFromShort(string $shortCode): ?string
    {
        $query = "SELECT magnet_url FROM shortened_urls WHERE short_code = :short_code";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':short_code', $shortCode, SQLITE3_TEXT);
        $result = $stmt->execute();
        $row = $result->fetchArray();
        return $row ? $row['magnet_url'] : null;
    }
}
