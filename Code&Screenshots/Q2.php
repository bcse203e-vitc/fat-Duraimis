<?php
function lineSum(string $filename, int $lineNumber): int {
    if ($lineNumber < 1 || !is_readable($filename)) {
        return 0;
    }
    $handle = fopen($filename, "r");
    if (!$handle) {
        return 0;
    }
    $current = 0;
    $result  = 0;

    while (($line = fgets($handle)) !== false) {
        $current++;
        $trimmed = trim($line);
        if ($trimmed === "" || str_starts_with($trimmed, "#")) {
            continue;
        }
        if ($current === $lineNumber) {
            // Split on whitespace
            $tokens = preg_split('/\s+/', $trimmed);

            foreach ($tokens as $token) {
                // Validate integer (handles +3, -4, 10, etc.)
                if (filter_var($token, FILTER_VALIDATE_INT) !== false) {
                    $result += (int)$token;
                }
            }

            fclose($handle);
            return $result;
        }
    }

    fclose($handle);
    return 0;
}
?>

