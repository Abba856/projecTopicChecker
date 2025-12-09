// Project Similarity Checker in JavaScript
// Equivalent to the Python Jupyter notebook

// Import required libraries
const fs = require('fs');
const csv = require('csv-parser');

class ProjectSimilarityChecker {
  constructor() {
    this.data = [];
    this.titleEmbeddings = [];
    this.abstractEmbeddings = [];
    this.stopWords = new Set([
      'i', 'me', 'my', 'myself', 'we', 'our', 'ours', 'ourselves', 'you', 'your', 
      'yours', 'yourself', 'yourselves', 'he', 'him', 'his', 'himself', 'she', 
      'her', 'hers', 'herself', 'it', 'its', 'itself', 'they', 'them', 'their', 
      'theirs', 'themselves', 'what', 'which', 'who', 'whom', 'this', 'that', 
      'these', 'those', 'am', 'is', 'are', 'was', 'were', 'be', 'been', 'being', 
      'have', 'has', 'had', 'having', 'do', 'does', 'did', 'doing', 'a', 'an', 
      'the', 'and', 'but', 'if', 'or', 'because', 'as', 'until', 'while', 'of', 
      'at', 'by', 'for', 'with', 'through', 'during', 'before', 'after', 'above', 
      'below', 'up', 'down', 'in', 'out', 'on', 'off', 'over', 'under', 'again', 
      'further', 'then', 'once'
    ]);
  }

  // Load CSV data
  async loadCSV(filePath) {
    console.log('⏳ Loading data from CSV...');
    this.data = [];
    
    try {
      return new Promise((resolve, reject) => {
        fs.createReadStream(filePath)
          .pipe(csv())
          .on('data', (row) => {
            this.data.push(row);
          })
          .on('end', () => {
            console.log(`✅ Data loaded successfully! Loaded ${this.data.length} records`);
            console.log('Sample data:', this.data[0]);
            resolve();
          })
          .on('error', (error) => {
            reject(error);
          });
      });
    } catch (error) {
      console.error('❌ Error loading CSV:', error);
      throw error;
    }
  }

  // Text preprocessing function
  cleanText(text) {
    if (!text || typeof text !== 'string') {
      return '';
    }

    // Convert to lowercase
    text = text.toLowerCase();
    
    // Remove special characters and digits
    text = text.replace(/[^a-zA-Z\s]/g, '');
    
    // Split into words
    const words = text.split(/\s+/);
    
    // Filter out stop words and empty strings
    const filteredWords = words.filter(word => 
      word.length > 0 && !this.stopWords.has(word)
    );
    
    // Join words back into a string
    return filteredWords.join(' ');
  }

  // Initialize the checker (placeholder since we're not using neural models)
  async initialize() {
    console.log('✅ Similarity checker initialized!');
  }

  // Simple TF-IDF inspired approach to create document vectors
  createDocumentVector(text) {
    const words = text.toLowerCase().split(/\s+/).filter(word => word.length > 0);
    const vector = {};
    
    for (const word of words) {
      vector[word] = (vector[word] || 0) + 1;
    }
    
    return vector;
  }
  
  // Calculate term frequency for a document vector
  calculateTF(docVector, totalTerms) {
    const tf = {};
    for (const [term, count] of Object.entries(docVector)) {
      tf[term] = count / totalTerms;
    }
    return tf;
  }

  // Calculate cosine similarity using a simpler approach
  cosineSimilarity(vecA, vecB) {
    // Get all unique terms
    const allTerms = new Set([...Object.keys(vecA), ...Object.keys(vecB)]);
    
    let dotProduct = 0;
    let magnitudeA = 0;
    let magnitudeB = 0;
    
    for (const term of allTerms) {
      const valA = vecA[term] || 0;
      const valB = vecB[term] || 0;
      
      dotProduct += valA * valB;
      magnitudeA += valA * valA;
      magnitudeB += valB * valB;
    }
    
    magnitudeA = Math.sqrt(magnitudeA);
    magnitudeB = Math.sqrt(magnitudeB);
    
    if (magnitudeA === 0 || magnitudeB === 0) {
      return 0;
    }
    
    return dotProduct / (magnitudeA * magnitudeB);
  }
  
  // Calculate TF-IDF based similarity
  async calculateSimilarity(textA, textB) {
    // Create document vectors
    const vecA = this.createDocumentVector(textA);
    const vecB = this.createDocumentVector(textB);
    
    // Calculate cosine similarity directly from the vectors
    return this.cosineSimilarity(vecA, vecB);
  }

  // Preprocess all data
  preprocessData() {
    console.log('⏳ Preprocessing text data...');
    
    this.data.forEach(row => {
      row.clean_title = this.cleanText(row.final_keywords || '');
      row.clean_abstract = this.cleanText(row.abstracts || '');
    });
    
    console.log('✅ Text preprocessing completed!');
  }

  // Prepare document vectors for all titles and abstracts
  prepareData() {
    console.log('⏳ Preparing document vectors for all data...');
    
    this.titleVectors = this.data.map(row => this.createDocumentVector(row.clean_title));
    this.abstractVectors = this.data.map(row => this.createDocumentVector(row.clean_abstract));
    
    console.log('✅ Document vectors created!');
  }

  // Check similarity for a new project
  async checkSimilarity(newTitle, newAbstract, topN = 3) {
    // Clean input
    const newTitleClean = this.cleanText(newTitle);
    const newAbstractClean = this.cleanText(newAbstract);

    // Create document vectors for new inputs
    const newTitleVector = this.createDocumentVector(newTitleClean);
    const newAbstractVector = this.createDocumentVector(newAbstractClean);

    // Calculate similarities using precomputed vectors
    const titleScores = this.titleVectors.map(vector => 
      this.cosineSimilarity(newTitleVector, vector)
    );
    
    const abstractScores = this.abstractVectors.map(vector => 
      this.cosineSimilarity(newAbstractVector, vector)
    );

    // Get top N indices for titles
    const topTitleIndices = titleScores
      .map((score, index) => ({ score, index }))
      .sort((a, b) => b.score - a.score)
      .slice(0, topN)
      .map(item => item.index);

    // Get top N indices for abstracts
    const topAbstractIndices = abstractScores
      .map((score, index) => ({ score, index }))
      .sort((a, b) => b.score - a.score)
      .slice(0, topN)
      .map(item => item.index);

    // Display results
    console.log('\n🔹 Top Similar Project Titles:');
    for (const idx of topTitleIndices) {
      console.log(`- ${this.data[idx].final_keywords || 'N/A'}  |  Similarity: ${(titleScores[idx] * 100).toFixed(2)}%`);
      console.log(`  Abstract: ${(this.data[idx].abstracts || '').substring(0, 200)}...`);
      console.log('');
    }

    console.log('\n🔹 Top Similar Project Abstracts:');
    for (const idx of topAbstractIndices) {
      console.log(`- ${this.data[idx].final_keywords || 'N/A'}  |  Similarity: ${(abstractScores[idx] * 100).toFixed(2)}%`);
      console.log(`  Abstract: ${(this.data[idx].abstracts || '').substring(0, 200)}...`);
      console.log('');
    }
  }

  // Main method to run the full pipeline
  async run() {
    try {
      // Load data
      await this.loadCSV('./paper_details_final_data.csv');
      
      // Preprocess data
      this.preprocessData();
      
      // Prepare data vectors
      this.prepareData();
      
      // Example usage
      const newTitle = "Design and Development of an Intelligent School Management System";
      const newAbstract = `
        This research focuses on automating school operations using artificial intelligence
        to improve record keeping, attendance, and staff management efficiency.
      `;
      
      console.log('\n⏳ Checking similarity for new project...');
      await this.checkSimilarity(newTitle, newAbstract, 3);
    } catch (error) {
      console.error('❌ Error running the similarity checker:', error);
    }
  }
}

// Run the similarity checker if this file is executed directly
if (require.main === module) {
  const checker = new ProjectSimilarityChecker();
  checker.run();
}

module.exports = ProjectSimilarityChecker;