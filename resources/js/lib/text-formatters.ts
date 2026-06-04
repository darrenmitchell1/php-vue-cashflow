function toAlphaDash(textString: string = ''): string {
  if (textString != null && textString !== '') {
    return textString.toLowerCase()                  // Convert to lowercase
                    .trim()                          // Remove leading/trailing spaces
                    .replace(/\s+/g, '_')            // Replace spaces with underscores
                    .replace(/[^a-z0-9_-]/g, '')     // Remove invalid characters
                    .replace(/-+/g, '-')             // Collapse multiple dashes into one
                    .replace(/_+/g, '_');            // Collapse multiple underscores into one           
  }

  return '';
}

export { toAlphaDash }
