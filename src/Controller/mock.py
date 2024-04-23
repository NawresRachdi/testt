from flask import Flask, jsonify, request

app = Flask(__name__)

class Piece:
    def __init__(self, nom=None, qualite=None, reference=None, quantite=None, prix=None):
        self.nom = nom
        self.qualite = qualite
        self.reference = reference
        self.quantite = quantite
        self.prix = prix

class PieceService:
    def createPiece(self, piece):
        # Logic for creating a piece
        pass
    
    def findPieceById(self, id):
        # Logic for finding a piece by ID
        pass
    
    def deletePiece(self, piece):
        # Logic for deleting a piece
        pass

@app.route('/api/pieces', methods=['GET'])
def list_pieces():
    # Logic to list all pieces
    pieces = []
    return jsonify(pieces)

@app.route('/api/pieces/<int:id>', methods=['GET'])
def get_piece_details(id):
    # Logic to get details of a specific piece
    piece = PieceService().findPieceById(id)
    return jsonify(piece.__dict__)

@app.route('/api/pieces', methods=['POST'])
def create_piece():
    data = request.get_json()
    piece = Piece(data['nom'], data['qualite'], data['reference'], data['quantite'], data['prix'])
    PieceService().createPiece(piece)
    return '', 201

@app.route('/api/pieces/<int:id>', methods=['PUT'])
def modify_piece(id):
    data = request.get_json()
    piece = PieceService().findPieceById(id)
    if not piece:
        return jsonify({'error': 'Entity not found'}), 404
    piece.nom = data['nom']
    piece.qualite = data['qualite']
    piece.reference = data['reference']
    piece.quantite = data['quantite']
    piece.prix = data['prix']
    # Save modified piece
    return jsonify({'message': 'Data modified successfully'})

@app.route('/api/pieces/<int:id>', methods=['DELETE'])
def delete_piece(id):
    piece = PieceService().findPieceById(id)
    if not piece:
        return 'Pièce non trouvée', 404
    PieceService().deletePiece(piece)
    return '', 204

@app.route('/api/pieces/search/<string:nom>', methods=['GET'])
def search_piece_by_nom(nom):
    # Logic to search for pieces by name
    pieces = []
    if not pieces:
        return jsonify({'message': 'Aucune pièce trouvée avec ce nom'}), 404
    response = [{'id': piece.id, 'nom': piece.nom, 'Qualite': piece.qualite, 'Référence': piece.reference, 'Quantité': piece.quantite, 'Prix': piece.prix} for piece in pieces]
    return jsonify(response)

if __name__ == '__main__':
    app.run(debug=True)
