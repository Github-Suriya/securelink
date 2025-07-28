# SecureLink

**SecureLink** is a lightweight, framework-agnostic PHP package that allows you to create temporary, self-expiring links. These links can expire based on time or number of clicks, making it ideal for securely sharing sensitive content or granting temporary access.

---

## Features

- Generate **time-limited** links (expire after configurable minutes)
- Generate **click-limited** links (expire after a certain number of clicks)
- Automatic expiry handling with customizable messages
- Simple and lightweight, using file storage or adaptable to other storages
- Easy integration with any PHP project (no framework required)
- Optional audit logging (can be extended)
- Secure token generation using PHP’s `random_bytes()`

---

## Table of Contents

- [Installation](#installation)  
- [Usage](#usage)  
  - [Generating Time-Limited Link](#generating-time-limited-link)  
  - [Generating Click-Limited Link](#generating-click-limited-link)  
  - [Handling Link Access (Redirection)](#handling-link-access-redirection)  
- [Configuration](#configuration)  
- [Project Structure](#project-structure)  
- [Advanced Usage](#advanced-usage)  
- [License](#license)

---

## Installation

1. Clone or download this repository to your project folder.  
2. Make sure your PHP version is 7.2+ (for `random_bytes()` support).  
3. Set writable permissions to the `storage/` directory, as it stores link metadata.

If you want to use Composer autoloading:

composer dump-autoload


---

## Usage

Below are basic usage examples of SecureLink using core PHP.

### Generating Time-Limited Link

require_once DIR . '/src/SecureLink.php';

// Initialize with storage folder path and secret key
$secureLink = new SecureLink(DIR . '/storage', 'your-secret-key');

// Create a link that expires in 30 minutes
$link = $secureLink->createTimeLink('https://example.com/secret-file.zip', 30);

echo "Your 30-minute temporary link: $link\n";


### Generating Click-Limited Link

require_once DIR . '/src/SecureLink.php';

$secureLink = new SecureLink(DIR . '/storage', 'your-secret-key');

// Create a link that expires after 5 clicks
$link = $secureLink->createClickLink('https://example.com/private-report.pdf', 5);

echo "Your 5-click temporary link: $link\n";


### Handling Link Access (Redirection)

Create a `secure.php` file that handles link validation and redirects users accordingly:

require_once DIR . '/src/SecureLink.php';

$secureLink = new SecureLink(DIR . '/storage', 'your-secret-key');

$token = $_GET['token'] ?? '';

$url = $secureLink->resolve($token);

if ($url && !in_array($url, ['Link expired', null])) {
header("Location: $url");
exit;
} else {
echo "Link expired or invalid.";
}


---

## Configuration

- **Storage Path:** The directory where link data (JSON files) are saved. Must be writable by your PHP process.
- **Secret Key:** Used internally for generating tokens securely (you can extend encryption if needed).
- **Base URL:** The package generates URLs pointing to your `secure.php` file. Update this URL in the `generateUrl()` method if your domain or path changes.

---

## Project Structure

securelink/
|-- src/
| |-- SecureLink.php # Core package class
|-- storage/ # Stores link metadata files
|-- secure.php # Link validation and redirector script
|-- example.php # Example usage script
|-- composer.json # Optional, for autoloading and package metadata
|-- README.md # This file


---

## Advanced Usage & Extensions

- **Password Protection:** Extend the package to add password validation before redirect.
- **Audit Logging:** Add functionality to log link accesses to a file or DB.
- **Database Support:** Swap file storage with a database like SQLite or MySQL.
- **Framework Integrations:** Provide adapters/middleware for Laravel, Symfony, etc.
- **Email Notifications:** Notify users when links are created or accessed.
- **Encryption:** Secure URLs or link metadata with encryption for extra security.

If you want help implementing any of these, feel free to open an issue or reach out!

---

## License

This project is licensed under the [MIT License](LICENSE).

---

## Contact

Created by SuryaDev — Feel free to reach out for questions or suggestions!

---

**Happy coding with SecureLink! 🚀**