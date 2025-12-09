# Project Similarity Checker (JavaScript Version)

This is the JavaScript conversion of the original Python Jupyter notebook for checking similarity between project titles and abstracts using sentence embeddings.

## Features

- Loads project data from a CSV file
- Preprocesses text (cleans, removes stop words)
- Uses Sentence-BERT model to generate embeddings
- Calculates cosine similarity between new projects and existing ones
- Returns top N most similar projects

## Requirements

- Node.js (v14 or higher)
- npm (v6 or higher)

## Installation

1. Make sure you have Node.js installed on your system
2. Navigate to the project directory:
   ```bash
   cd /var/www/mywebsite.local/public_html/projecTopicChecker/ml
   ```
3. Install the required dependencies:
   ```bash
   npm install
   ```

## Usage

1. Make sure your CSV file `paper_details_final_data.csv` is in the same directory
2. The CSV file should have at least two columns: `final_keywords` and `abstracts`
3. Run the similarity checker:
   ```bash
   npm start
   ```
   or
   ```bash
   node similarity-checker.js
   ```

## How It Works

1. **Load Data**: Reads the CSV file containing project information
2. **Preprocess**: Cleans the text data by converting to lowercase, removing special characters, and filtering out stop words
3. **Encode**: Uses a Sentence-BERT model to generate embeddings for all project titles and abstracts
4. **Similarity Check**: Calculates cosine similarity between a new project and existing ones
5. **Results**: Returns the top N most similar projects

## Configuration

You can modify the following parameters in the code:
- `topN`: Number of similar projects to return (default: 3)
- Model: The Sentence-BERT model used (default: 'all-MiniLM-L6-v2')

## Dependencies

- `@xenova/transformers`: JavaScript implementation of Hugging Face transformers
- `csv-parser`: For parsing CSV files
- `fs`: Node.js file system module

## Notes

- The first run may take longer as the model needs to be downloaded
- Make sure your CSV file has the required columns (`final_keywords` and `abstracts`)

## Example Usage

```javascript
const checker = new ProjectSimilarityChecker();
await checker.loadCSV('paper_details_final_data.csv');
await checker.initializeModel();
await checker.encodeData();

await checker.checkSimilarity(
  "Design and Development of an Intelligent School Management System",
  "This research focuses on automating school operations using artificial intelligence to improve record keeping, attendance, and staff management efficiency."
);
```