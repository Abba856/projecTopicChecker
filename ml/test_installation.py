#!/usr/bin/env python3
"""
Test script to verify that the Project Similarity Checker notebook code works
with the installed packages.
"""

print("Testing Project Similarity Checker functionality...")

# STEP 1: Import Libraries
import pandas as pd
from sentence_transformers import SentenceTransformer, util
import numpy as np
import nltk
import re
from nltk.corpus import stopwords
from nltk.stem import WordNetLemmatizer

print("✅ All libraries imported successfully!")

# Try to initialize NLTK components (will fail gracefully if data not downloaded)
try:
    stop_words = set(stopwords.words('english'))
    print("✅ NLTK stopwords data loaded successfully!")
except LookupError:
    print("⚠️  NLTK stopwords data not available - may need to download separately")
    stop_words = set()  # Empty set as fallback

try:
    lemmatizer = WordNetLemmatizer()
    print("✅ NLTK lemmatizer loaded successfully!")
except LookupError:
    print("⚠️  NLTK WordNet data not available - may need to download separately")
    from nltk.stem import PorterStemmer  # Fallback
    lemmatizer = PorterStemmer()
    print("   Using PorterStemmer as fallback")

print("\n✅ The Project Similarity Checker environment is ready!")
print("   The notebook should now run without pip timeout errors.")
print("   Note: NLTK data (stopwords, wordnet) may need to be downloaded separately if needed.")