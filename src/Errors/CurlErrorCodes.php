<?php declare( strict_types = 1 );
namespace CodeKandis\TradioApi\Errors;

/**
 * Represents an enumeration of CURL error codes.
 * @package codekandis/tradio-api
 * @author Christian Ramelow <info@codekandis.net>
 */
abstract class CurlErrorCodes
{
	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_UNSUPPORTED_PROTOCOL = 1;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_FAILED_INIT = 2;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_URL_MALFORMAT = 3;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_NOT_BUILT_IN = 4;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_COULDNT_RESOLVE_PROXY = 5;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_COULDNT_RESOLVE_HOST = 6;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_COULDNT_CONNECT = 7;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_WEIRD_SERVER_REPLY = 8;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_REMOTE_ACCESS_DENIED = 9;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_FTP_ACCEPT_FAILED = 10;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_FTP_WEIRD_PASS_REPLY = 11;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_FTP_ACCEPT_TIMEOUT = 12;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_FTP_WEIRD_PASV_REPLY = 13;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_FTP_WEIRD_227_FORMAT = 14;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_FTP_CANT_GET_HOST = 15;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_HTTP2 = 16;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_FTP_COULDNT_SET_TYPE = 17;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_PARTIAL_FILE = 18;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_FTP_COULDNT_RETR_FILE = 19;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_QUOTE_ERROR = 21;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_HTTP_RETURNED_ERROR = 22;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_WRITE_ERROR = 23;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_UPLOAD_FAILED = 25;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_READ_ERROR = 26;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_OUT_OF_MEMORY = 27;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_OPERATION_TIMEDOUT = 28;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_FTP_PORT_FAILED = 30;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_FTP_COULDNT_USE_REST = 31;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_RANGE_ERROR = 33;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_HTTP_POST_ERROR = 34;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_SSL_CONNECT_ERROR = 35;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_BAD_DOWNLOAD_RESUME = 36;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_FILE_COULDNT_READ_FILE = 37;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_LDAP_CANNOT_BIND = 38;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_LDAP_SEARCH_FAILED = 39;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_FUNCTION_NOT_FOUND = 41;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_ABORTED_BY_CALLBACK = 42;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_BAD_FUNCTION_ARGUMENT = 43;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_INTERFACE_FAILED = 45;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_TOO_MANY_REDIRECTS = 47;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_UNKNOWN_OPTION = 48;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_TELNET_OPTION_SYNTAX = 49;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_GOT_NOTHING = 52;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_SSL_ENGINE_NOTFOUND = 53;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_SSL_ENGINE_SETFAILED = 54;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_SEND_ERROR = 55;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_RECV_ERROR = 56;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_SSL_CERTPROBLEM = 58;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_SSL_CIPHER = 59;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_PEER_FAILED_VERIFICATION = 60;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_BAD_CONTENT_ENCODING = 61;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_LDAP_INVALID_URL = 62;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_FILESIZE_EXCEEDED = 63;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_USE_SSL_FAILED = 64;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_SEND_FAIL_REWIND = 65;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_SSL_ENGINE_INITFAILED = 66;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_LOGIN_DENIED = 67;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_TFTP_NOTFOUND = 68;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_TFTP_PERM = 69;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_REMOTE_DISK_FULL = 70;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_TFTP_ILLEGAL = 71;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_TFTP_UNKNOWNID = 72;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_REMOTE_FILE_EXISTS = 73;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_TFTP_NOSUCHUSER = 74;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_CONV_FAILED = 75;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_CONV_REQD = 76;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_SSL_CACERT_BADFILE = 77;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_REMOTE_FILE_NOT_FOUND = 78;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_SSH = 79;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_SSL_SHUTDOWN_FAILED = 80;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_AGAIN = 81;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_SSL_CRL_BADFILE = 82;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_SSL_ISSUER_ERROR = 83;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_FTP_PRET_FAILED = 84;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_RTSP_CSEQ_ERROR = 85;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_RTSP_SESSION_ERROR = 86;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_FTP_BAD_FILE_LIST = 87;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_CHUNK_FAILED = 88;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_NO_CONNECTION_AVAILABLE = 89;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_SSL_PINNEDPUBKEYNOTMATCH = 90;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_SSL_INVALIDCERTSTATUS = 91;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_HTTP2_STREAM = 92;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_RECURSIVE_API_CALL = 93;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_AUTH_ERROR = 94;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_HTTP3 = 95;

	/**
	 * @see https://curl.se/libcurl/c/libcurl-errors.html
	 * @var int
	 */
	public const CURLE_QUIC_CONNECT_ERROR = 96;
}
