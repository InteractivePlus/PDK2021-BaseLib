<?php
namespace InteractivePlus\PDK2021Core\EXT_Ticket;
class OAuthTicketFormat{
    const TICKET_ID_BYTE_LENGTH = 16;
    public static function getTicketIDByteLength() : int{
        return self::TICKET_ID_BYTE_LENGTH;
    }
    public static function getTicketIDLength() : int{
        return self::TICKET_ID_BYTE_LENGTH * 2;
    }
    public static function isValidTicketID(string $ticketID) : bool{
        return strlen($ticketID) === self::getTicketIDLength();
    }
    public static function formatTicketID(string $ticketID) : string{
        return strtolower($ticketID);
    }
    public static function generateTicketID() : string{
        return self::formatTicketID(bin2hex(random_bytes(self::TICKET_ID_BYTE_LENGTH)));
    }
    public static function isTicketIDEqual(string $ticketID1, string $ticketID2) : bool{
        return self::formatTicketID($ticketID1) === self::formatTicketID($ticketID2);
    }
}